<?php

?>

<script src="<?=assets_url('js/bootstrap-star-rating.js');?>"></script>

<div class="container-fluid">
    Default stars
    <div id="stars-default"><input type="hidden" name="rating" /></div>
    Green stars with a callback and a preset value<div id="stars-green" data-rating="3"></div>
    Ten hearts
    <div id="stars-herats" data-rating="6"></div>
</div>

<script>
$(document).ready(function() {
    $("#stars-default").rating();
    $("#stars-green").rating('create', {
        coloron: 'green',
        onClick: function() {
            alert('rating is ' + this.attr('data-rating'));
        }
    });
    $("#stars-herats").rating('create', {
        coloron: 'red',
        limit: 10,
        glyph: 'glyphicon-heart'
    });
});
</script>