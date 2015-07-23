function checkOption() {
    if (document.getElementById('oppia').checked) {
        document.getElementById('oppia_id').style.display = 'block';
        document.getElementById('hotspot_url').style.display = 'none';
    }
    else {
        document.getElementById('oppia_id').style.display = 'none';
        document.getElementById('hotspot_url').style.display = 'block';
    }

}
