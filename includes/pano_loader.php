<?php

if (isset($_GET['id'])){
	$pano_id = $_GET['id'];

	// Make the pano
	// $pano = build_pano($pano_id);

	build_pano_xml($pano_id);
}


function build_pano_xml($pano_id){

	$pano_url = "http://tot.boldapps.net/wp-content/panos/" . $pano_id . "/";

	// Get XML
	$main_xml = xml_middle_man($pano_url);

	// Create object
	$pano_xml_obj = build_simple_xml_obj($main_xml, true);

	// Fix reference links
	$fixed_xml_object = fix_references($pano_xml_obj);

	// turn object back into XML

	// Output XML
	spit_out_xml($main_xml);
}

function fix_references($xml_object){
	return $xml_object;
}

function spit_out_xml($xml){
	// We are returning xml
	header('Content-Type: text/xml');

	echo $xml;
	die();
}

function build_simple_xml_obj($xml, $debugging = false){
	$obj = simplexml_load_string($xml);

	// Display the object when manipulating it
	if ($debugging){
		print_r($obj);
		die();
	}

	return $obj;
}

function xml_middle_man($pano_url){
	return '<krpano version="1.17.3" title="Virtual Tour" onstart="startup();">

		<include url="' . $pano_url .  'skin/vtourskin.xml" />

		<!-- set skin settings: bingmaps? gyro? thumbnail controlling? tooltips? -->
		<skin_settings bingmaps="false"
		               bingmaps_key=""
		               bingmaps_zoombuttons="false"
		               gyro="true"
		               thumbs_width="120" thumbs_height="80" thumbs_padding="10" thumbs_crop="0|40|240|160"
		               thumbs_opened="false"
		               thumbs_text="false"
		               thumbs_dragging="true"
		               thumbs_onhoverscrolling="false"
		               thumbs_scrollbuttons="false"
		               thumbs_scrollindicator="false"
		               thumbs_loop="false"
		               tooltips_thumbs="false"
		               tooltips_hotspots="false"
		               tooltips_mapspots="false"
		               controlbar_offset="20"
		               />

		<!-- set optional skin logo url -->
		<layer name="skin_logo" url="" scale="0.25" opened_onclick="openurl(\'...\',_blank);" />


		<action name="startup">
			if(startscene === null, copy(startscene,scene[0].name));
			loadscene(get(startscene), null, MERGE);
		</action>

		
		<scene name="scene_hairstyling4" title="hairstyling4" onstart="" thumburl="' . $pano_url .  'panos/hairstyling4.tiles/thumb.jpg" lat="" lng="" heading="">

			<view hlookat="0" vlookat="0" fovtype="MFOV" fov="120" maxpixelzoom="2.0" fovmin="70" fovmax="140" limitview="auto" />

			<preview url="' . $pano_url .  'panos/hairstyling4.tiles/preview.jpg" />

			<image type="CUBE" multires="true" tilesize="512" progressive="false">
				<level tiledimagewidth="7950" tiledimageheight="7950">
					<cube url="' . $pano_url .  'panos/hairstyling4.tiles/%s/l5/%v/l5_%s_%v_%h.jpg" />
				</level>
				<level tiledimagewidth="3976" tiledimageheight="3976">
					<cube url="' . $pano_url .  'panos/hairstyling4.tiles/%s/l4/%v/l4_%s_%v_%h.jpg" />
				</level>
				<level tiledimagewidth="2048" tiledimageheight="2048">
					<cube url="' . $pano_url .  'panos/hairstyling4.tiles/%s/l3/%v/l3_%s_%v_%h.jpg" />
				</level>
				<level tiledimagewidth="1024" tiledimageheight="1024">
					<cube url="' . $pano_url .  'panos/hairstyling4.tiles/%s/l2/%v/l2_%s_%v_%h.jpg" />
				</level>
				<level tiledimagewidth="512" tiledimageheight="512">
					<cube url="' . $pano_url .  'panos/hairstyling4.tiles/%s/l1/%v/l1_%s_%v_%h.jpg" />
				</level>
				<mobile>
					<cube url="' . $pano_url .  'panos/hairstyling4.tiles/mobile_%s.jpg" />
				</mobile>
			</image>

			<!-- place your scene hotspots here -->

		</scene>

		<scene name="scene_kitchenpeople_optimized_0" title="kitchenpeople_optimized_0" onstart="" thumburl="' . $pano_url .  'panos/kitchenpeople_optimized_0.tiles/thumb.jpg" lat="" lng="" heading="">

			<view hlookat="0" vlookat="0" fovtype="MFOV" fov="120" maxpixelzoom="2.0" fovmin="70" fovmax="140" limitview="auto" />

			<preview url="' . $pano_url .  'panos/kitchenpeople_optimized_0.tiles/preview.jpg" />

			<image type="CUBE" multires="true" tilesize="512" progressive="false">
				<level tiledimagewidth="6036" tiledimageheight="6036">
					<cube url="' . $pano_url .  'panos/kitchenpeople_optimized_0.tiles/%s/l4/%v/l4_%s_%v_%h.jpg" />
				</level>
				<level tiledimagewidth="3072" tiledimageheight="3072">
					<cube url="' . $pano_url .  'panos/kitchenpeople_optimized_0.tiles/%s/l3/%v/l3_%s_%v_%h.jpg" />
				</level>
				<level tiledimagewidth="1536" tiledimageheight="1536">
					<cube url="' . $pano_url .  'panos/kitchenpeople_optimized_0.tiles/%s/l2/%v/l2_%s_%v_%h.jpg" />
				</level>
				<level tiledimagewidth="768" tiledimageheight="768">
					<cube url="' . $pano_url .  'panos/kitchenpeople_optimized_0.tiles/%s/l1/%v/l1_%s_%v_%h.jpg" />
				</level>
				<mobile>
					<cube url="' . $pano_url .  'panos/kitchenpeople_optimized_0.tiles/mobile_%s.jpg" />
				</mobile>
			</image>

			<!-- place your scene hotspots here -->

		</scene>

		<scene name="scene_mainpeople_smaller" title="mainpeople_smaller" onstart="" thumburl="' . $pano_url .  'panos/mainpeople_smaller.tiles/thumb.jpg" lat="" lng="" heading="">

			<view hlookat="0" vlookat="0" fovtype="MFOV" fov="120" maxpixelzoom="2.0" fovmin="70" fovmax="140" limitview="range" vlookatmin="-84.545" vlookatmax="84.545" />

			<preview url="' . $pano_url .  'panos/mainpeople_smaller.tiles/preview.jpg" />

			<image type="CUBE" multires="true" tilesize="512" progressive="false">
				<level tiledimagewidth="6518" tiledimageheight="6518">
					<cube url="' . $pano_url .  'panos/mainpeople_smaller.tiles/%s/l4/%v/l4_%s_%v_%h.jpg" />
				</level>
				<level tiledimagewidth="3260" tiledimageheight="3260">
					<cube url="' . $pano_url .  'panos/mainpeople_smaller.tiles/%s/l3/%v/l3_%s_%v_%h.jpg" />
				</level>
				<level tiledimagewidth="1630" tiledimageheight="1630">
					<cube url="' . $pano_url .  'panos/mainpeople_smaller.tiles/%s/l2/%v/l2_%s_%v_%h.jpg" />
				</level>
				<level tiledimagewidth="816" tiledimageheight="816">
					<cube url="' . $pano_url .  'panos/mainpeople_smaller.tiles/%s/l1/%v/l1_%s_%v_%h.jpg" />
				</level>
				<mobile>
					<cube url="' . $pano_url .  'panos/mainpeople_smaller.tiles/mobile_%s.jpg" />
				</mobile>
			</image>

			<!-- place your scene hotspots here -->

		</scene>

		<scene name="scene_warroom_moody" title="warroom_moody" onstart="" thumburl="' . $pano_url .  'panos/warroom_moody.tiles/thumb.jpg" lat="" lng="" heading="">

			<view hlookat="0" vlookat="0" fovtype="MFOV" fov="120" maxpixelzoom="2.0" fovmin="70" fovmax="140" limitview="range" vlookatmin="-85.455" vlookatmax="85.455" />

			<preview url="' . $pano_url .  'panos/warroom_moody.tiles/preview.jpg" />

			<image type="CUBE" multires="true" tilesize="512" progressive="false">
				<level tiledimagewidth="6366" tiledimageheight="6366">
					<cube url="' . $pano_url .  'panos/warroom_moody.tiles/%s/l4/%v/l4_%s_%v_%h.jpg" />
				</level>
				<level tiledimagewidth="3184" tiledimageheight="3184">
					<cube url="' . $pano_url .  'panos/warroom_moody.tiles/%s/l3/%v/l3_%s_%v_%h.jpg" />
				</level>
				<level tiledimagewidth="1536" tiledimageheight="1536">
					<cube url="' . $pano_url .  'panos/warroom_moody.tiles/%s/l2/%v/l2_%s_%v_%h.jpg" />
				</level>
				<level tiledimagewidth="768" tiledimageheight="768">
					<cube url="' . $pano_url .  'panos/warroom_moody.tiles/%s/l1/%v/l1_%s_%v_%h.jpg" />
				</level>
				<mobile>
					<cube url="' . $pano_url .  'panos/warroom_moody.tiles/mobile_%s.jpg" />
				</mobile>
			</image>

			<!-- place your scene hotspots here -->

		</scene>


	</krpano>';
}