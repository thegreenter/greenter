var anchors = Array.from(document.getElementsByClassName("md-nav")[0].getElementsByTagName("a"));
anchors.forEach(function(anchor) {
	var sep = anchor.innerText.indexOf("|");
	if (sep != -1) {
		anchor.href = anchor.innerText.substring(sep + 1, anchor.innerText.length);
		anchor.innerText = anchor.innerText.substring(0,sep);
		anchor.target = "_blank";
	}
});