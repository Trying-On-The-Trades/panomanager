<?php

    $mission           = $_POST['mission_id'];
    $domain            = $_POST['hotspot_domain_id'];
    $hotspot_info      = $_POST['hotspot_info'];
    $hotspot_menu_name = $_POST['hotspot_menu_name'];
    $hotspot_name      = $_POST['hotspot_name'];
    $hotspot_points    = $_POST['hotspot_points'];
    $hotspot_type      = $_POST['hotspot_type'];
    $point_x           = $_POST['point_x'];
    $point_y           = $_POST['point_y'];
    $hotspot_icon      = $_POST['hotspot_icon'];
    $hotspot_menu      = $_POST['hotspot_menu'];
    $deck_id           = $_POST['deck_id'];
    $game_type         = $_POST['game_type'];
    $game_cat          = $_POST['game_cat'];
    $pano_id           = $_POST['pano_id'];
    $item_id           = $_POST['item_id'];
    $hotspot_url       = $_POST['hotspot_url'];
    $oppia_id          = $_POST['oppia_id'];
    $size              = $_POST['hotspot_size'];
    $max_attempts      = $_POST['max_attempts'];

    if(isset($_POST['hotspot_zoom'])) {
        $hotspot_zoom = $_POST['hotspot_zoom'];
        if($hotspot_zoom == 'on'){
            $hotspot_zoom = 'true';
        } elseif($hotspot_zoom == 'off') {
            $hotspot_zoom = 'false';
        } else {
            $hotspot_zoom = 'false';
        }
    }



    if($game_type == "url"){
        $game_type = $_POST['url_type'];
    }

?>

<!DOCTYPE html>
<html lang="en">
<head>
    <script src="http://ajax.googleapis.com/ajax/libs/jquery/1.11.2/jquery.min.js"></script>
    <script type="text/javascript">

        var url               = document.location.origin + "/wp-admin/admin-post.php";
        var mission           = '';
        var domain            = '';
        var hotspot_info      = '';
        var point_x           = '';
        var point_y           = '';
        var hotspot_icon      = '';
        var deck_id           = '';
        var game_type         = '';
        var game_cat          = '';
        var hotspot_name      = '';
        var hotspot_menu_name = '';
        var hotspot_points    = '';
        var hotspot_menu      = '';
        var hotspot_url       = '';
        var hotspot_type      = '';
        var item_id           = '';
        var oppia_id          = '';
        var hotspot_zoom      = '';
        var size              = '';
        var max_attempts      = '';

        mission           = <?=$mission?>;
        domain            = '<?=$domain?>';
        hotspot_info       = '<?=$hotspot_info?>';
        point_x           = <?=$point_x?>;
        point_y           = <?=$point_y?>;
        hotspot_icon      = '<?=$hotspot_icon?>';
        deck_id           = '<?=$deck_id?>';
        game_type         = '<?=$game_type?>';
        game_cat          = '<?=$game_cat?>';
        hotspot_name      = '<?=$hotspot_name ?>';
        hotspot_menu_name = '<?=$hotspot_menu_name?>';
        hotspot_points    = '<?=$hotspot_points?>';
        hotspot_menu      = '<?=$hotspot_menu?>';
        hotspot_url       = '<?=$hotspot_url?>';
        hotspot_type      = '<?=$hotspot_type?>';
        item_id           = '<?=$item_id ?>';
        oppia_id          = '<?=$oppia_id ?>';
        hotspot_zoom      = '<?=$hotspot_zoom ?>';
        size              = '<?=$size ?>';
        max_attempts      = '<?=$max_attempts ?>';

        var icon = false;
        var menu = false;

        if('<?=$hotspot_icon?>'){
            icon = true;
        }

        if('<?=$hotspot_menu?>'){
            menu = true;
        }

        function add_new_hotspot(domain_id, mission_id, hotspot_info, hotspot_icon, x, y, deck_id,
                                 game_type, game_cat, url, hotspot_name, hotspot_menu_name, hotspot_points, hotspot_menu, hotspot_url,
                                 hotspot_type, oppia_id, hotspot_zoom, size, max_attempts) {

            $.ajax({
                type: 'POST',
                url: url,
                data: {
                    action: 'create_new_hotspot_ajax',
                    mission_id: mission_id,
                    domain_id: domain_id,
                    hotspot_info: hotspot_info,
                    hotspot_icon: hotspot_icon,
                    hotspot_menu: hotspot_menu,
                    hotspot_name: hotspot_name,
                    hotspot_menu_name, hotspot_menu_name,
                    hotspot_points: hotspot_points,
                    hotspot_x: x,
                    hotspot_y: y,
                    deck_id: deck_id,
                    game_type: game_type,
                    game_cat: game_cat,
                    hotspot_url: hotspot_url,
                    hotspot_type: hotspot_type,
                    oppia_id: oppia_id,
                    hotspot_zoom: hotspot_zoom,
                    size: size,
                    max_attempts: max_attempts
                },
                success: function (d) {
                    //alert('Hotspot Added!' + d);
                    window.location.href = document.location.origin + '/pano/?pano_id=<?=$pano_id?>';
                },
                error: function (d) {
                    alert('Hotspot Fail!');
                }
            });

        }

        function add_new_shop(domain_id, mission_id, hotspot_info, hotspot_icon, x, y, item_id, url,
                              hotspot_name, hotspot_menu_name, hotspot_points, hotspot_menu, hotspot_url,
                              hotspot_type, hotspot_zoom, size, max_attempts) {

            $.ajax({
                type: 'POST',
                url: url,
                data: {
                    action: 'create_new_hotspot_ajax',
                    mission_id: mission_id,
                    domain_id: domain_id,
                    hotspot_info: hotspot_info,
                    hotspot_icon: hotspot_icon,
                    hotspot_menu: hotspot_menu,
                    hotspot_name: hotspot_name,
                    hotspot_menu_name: hotspot_menu_name,
                    hotspot_points: hotspot_points,
                    hotspot_x: x,
                    hotspot_y: y,
                    item_id: item_id,
                    hotspot_url: hotspot_url,
                    hotspot_type: hotspot_type,
                    hotspot_zoom: hotspot_zoom,
                    size: size,
                    max_attempts: max_attempts
                },
                success: function (d) {
                    //alert('Hotspot Added!' + d);
                    window.location.href = document.location.origin + '/pano/?pano_id=<?=$pano_id?>';
                },
                error: function (d) {
                    alert('Hotspot Fail!');
                }
            });


        }

        <?php if(is_numeric($deck_id)): ?>
            add_new_hotspot(domain, mission, hotspot_info, icon, point_x, point_y, deck_id, game_type, game_cat, url, hotspot_name, hotspot_menu_name, hotspot_points, menu, hotspot_url, hotspot_type, oppia_id, hotspot_zoom, size, max_attempts);
        <?php elseif(is_numeric($item_id)): ?>
            add_new_shop(domain, mission, hotspot_info, icon, point_x, point_y, item_id, url, hotspot_name, hotspot_menu_name, hotspot_points, menu, hotspot_url, hotspot_type, hotspot_zoom, size, max_attempts);
        <?php else : ?>
            add_new_hotspot(domain, mission, hotspot_info, icon, point_x, point_y, deck_id, game_type, game_cat, url, hotspot_name, hotspot_menu_name, hotspot_points, menu, hotspot_url, hotspot_type, oppia_id, hotspot_zoom, size, max_attempts);
        <?php endif; ?>
    </script>
</head>
</html>
