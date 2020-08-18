<?xml version="1.0" encoding="UTF-8"?>
<xsl:stylesheet version="1.0"
                xmlns:xsl="http://www.w3.org/1999/XSL/Transform"
                xmlns:cbc="urn:oasis:names:specification:ubl:schema:xsd:CommonBasicComponents-2"
                xmlns="urn:oasis:names:specification:ubl:schema:xsd:Invoice-2">
    <xsl:template match="/*">
        <xsl:variable name="ublVesion" select="cbc:UBLVersionID" />
            <xsl:if test="not($ublVesion = '2.1')">
                <xsl:variable name="result" select="concat('1|2074|UBLVersionID - La versión del UBL no es correcta|Invoice/UBLVersionID|', $ublVesion)"/>
                <xsl:message terminate="yes">
                    <xsl:value-of select="$result"/>
                </xsl:message>
            </xsl:if>
    </xsl:template>
</xsl:stylesheet>