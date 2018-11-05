<?php
/**
 * Created by PhpStorm.
 * User: Giansalex
 * Date: 16/07/2017
 * Time: 13:00.
 */

namespace Greenter\Zip;

/**
 * Class ZipFile.
 */
class ZipFly implements CompressInterface, DecompressInterface
{
    const UNZIP_FORMAT = 'Vsig/vver/vflag/vmeth/vmodt/vmodd/Vcrc/Vcsize/Vsize/vnamelen/vexlen';

    /**
     * Array to store compressed data.
     *
     * @private  array    $datasec
     */
    private $datasec;
    /**
     * Central directory.
     *
     * @private  array    $ctrl_dir
     */
    private $ctrl_dir;
    /**
     * End of central directory record.
     *
     * @private  string   $eof_ctrl_dir
     */
    private $eof_ctrl_dir = "\x50\x4b\x05\x06\x00\x00\x00\x00";
    /**
     * Last offset position.
     *
     * @private  integer  $old_offset
     */
    private $old_offset;

    /**
     * ZipFly constructor.
     */
    public function __construct()
    {
        $this->clear();
    }

    /**
     * Converts an Unix timestamp to a four byte DOS date and time format (date
     * in high two bytes, time in low two bytes allowing magnitude comparison).
     *
     * @param int $unixtime the current Unix timestamp
     *
     * @return int the current date in a four byte DOS format
     */
    public function unix2DosTime($unixtime = 0)
    {
        $timearray = (0 == $unixtime) ? getdate() : getdate($unixtime);
        if ($timearray['year'] < 1980) {
            $timearray['year'] = 1980;
            $timearray['mon'] = 1;
            $timearray['mday'] = 1;
            $timearray['hours'] = 0;
            $timearray['minutes'] = 0;
            $timearray['seconds'] = 0;
        } // end if
        return (($timearray['year'] - 1980) << 25)
            | ($timearray['mon'] << 21)
            | ($timearray['mday'] << 16)
            | ($timearray['hours'] << 11)
            | ($timearray['minutes'] << 5)
            | ($timearray['seconds'] >> 1);
    }

    /**
     * Adds "file" to archive.
     *
     * @param string $data file contents
     * @param string $name name of the file in the archive (may contains the path)
     * @param int    $time the current timestamp
     */
    public function addFile($data, $name, $time = 0)
    {
        $name = str_replace('\\', '/', $name);
        $hexdtime = pack('V', $this->unix2DosTime($time));
        $frd = "\x50\x4b\x03\x04";
        $frd .= "\x14\x00";            // ver needed to extract
        $frd .= "\x00\x00";            // gen purpose bit flag
        $frd .= "\x08\x00";            // compression method
        $frd .= $hexdtime;             // last mod time and date
        // "local file header" segment
        list($zdata, $part) = $this->getPartsFromData($data, $name);

        $frd .= $part.$name;
        // "file data" segment
        $frd .= $zdata;
        // echo this entry on the fly, ...
        $this->datasec[] = $frd;
        // now add to central directory record
        $cdrec = "\x50\x4b\x01\x02";
        $cdrec .= "\x00\x00";                // version made by
        $cdrec .= "\x14\x00";                // version needed to extract
        $cdrec .= "\x00\x00";                // gen purpose bit flag
        $cdrec .= "\x08\x00";                // compression method
        $cdrec .= $hexdtime;                 // last mod time & date
        $cdrec .= $part;
        // file comment length, disk number start, internal file attributes
        $cdrec .= str_repeat(pack('v', 0), 3);
        $cdrec .= pack('V', 32);            // external file attributes
        // - 'archive' bit set
        $cdrec .= pack('V', $this->old_offset); // relative offset of local header
        $this->old_offset += strlen($frd);
        $cdrec .= $name;
        // optional extra field, file comment goes here
        // save to central directory
        $this->ctrl_dir[] = $cdrec;
    }

    private function getPartsFromData($data, $name)
    {
        $zdata = gzcompress($data);
        $zdata = substr(substr($zdata, 0, strlen($zdata) - 4), 2); // fix crc bug
        $unc_len = strlen($data);
        $crc = crc32($data);
        $c_len = strlen($zdata);

        $frd = pack('V', $crc);             // crc32
        $frd .= pack('V', $c_len);          // compressed filesize
        $frd .= pack('V', $unc_len);        // uncompressed filesize
        $frd .= pack('v', strlen($name));   // length of filename
        $frd .= pack('v', 0);         // extra field length

        return [$zdata, $frd];
    }

    /**
     * Echo central dir if ->doWrite==true, else build string to return.
     *
     * @return string if ->doWrite {empty string} else the ZIP file contents
     */
    public function file()
    {
        $ctrldir = implode('', $this->ctrl_dir);
        $header = $ctrldir.
            $this->eof_ctrl_dir.
            pack('v', sizeof($this->ctrl_dir)). //total #of entries "on this disk"
            pack('v', sizeof($this->ctrl_dir)). //total #of entries overall
            pack('V', strlen($ctrldir)).          //size of central dir
            pack('V', $this->old_offset).       //offset to start of central dir
            "\x00\x00";                            //.zip file comment length

        // Return entire ZIP archive as string
        $data = implode('', $this->datasec);

        return $data.$header;
    }

    /**
     * Comprime el contenido del archivo con el nombre especifico y retorna el contenido del zip.
     *
     * @param string $filename
     * @param string $content
     *
     * @return string
     */
    public function compress($filename, $content)
    {
        $this->addFile($content, $filename);
        $zip = $this->file();
        $this->clear();

        return $zip;
    }

    private function clear()
    {
        $this->datasec = [];
        $this->ctrl_dir = [];
        $this->old_offset = 0;
    }

    /**
     * Extract files.
     *
     * @param string        $content
     * @param callable|null $filter
     *
     * @return array
     */
    public function decompress($content, callable $filter = null)
    {
        $start = 0;
        $result = [];

        while (true) {
            $dat = substr($content, $start, 30);
            if (empty($dat)) {
                break;
            }

            $head = unpack(self::UNZIP_FORMAT, $dat);
            $filename = substr(substr($content, $start), 30, $head['namelen']);
            if (empty($filename)) {
                break;
            }
            $count = 30 + $head['namelen'] + $head['exlen'];

            if (!$filter || $filter($filename)) {
                $result[] = [
                    'filename' => $filename,
                    'content' => gzinflate(substr($content, $start + $count, $head['csize'])),
                ];
            }

            $start += $count + $head['csize'];
        }

        return $result;
    }
}
