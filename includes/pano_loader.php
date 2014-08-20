<?php

// We are returning xml
header('Content-Type: text/xml');

$xml = '<?xml version="1.0" encoding="UTF-8"?>
<krpano version="1.17"
        onstart="startup"
        logkey="false"
        bgcolor="#ffffff"
        projectfloorplanurl=""
        projecttitleid="project_title"
        projectdescriptionid="">

  <!-- generated by Panotour Pro V2.1.3 64bits : 16-07-2014 13-27-24 -->
  <!-- Plugins and Spot Styles -->
  <include url="%FIRSTXML%/pano_skin.xml"/>
  <!-- Core actions -->
  <include url="%FIRSTXML%/pano_core.xml"/>
  <!-- Tour Messages -->
  <include url="%`%/pano_messages_en.xml"/>

  <action name="startup">
    if (s !== null, if (startscene === null, set(startscene, get(s));); );
    if (startscene === null,
      set(startscene, pano11);
    );
    mainloadscene(get(startscene));
    if (h !== null,
      if (v !== null,
        if (f !== null,
          lookat(get(h), get(v), get(f));
         ,
          lookat(get(h), get(v));
        );
      );
    );
  </action>

  <!-- 3 Groups -->

  <!-- Group Group 12 : 1 panoramas -->
  

<!-- **** @PanoName="mainpeople" @PanoFile="/Volumes/Macintosh HD 3/Panoramas/Bold/main people/cube faces/mainpeople_0.psb" **** -->
<scene name="pano11"
       heading="0"
       thumburl="%FIRSTXML%/mainpeople_11/thumbnail.jpg"
       backgroundsound=""
       backgroundsoundloops="0"
       titleid="pano11_title"
       descriptionid=""
       multires="true"
       planar="false"
       full360="true">

    <autorotate horizon="13.247107" tofov="74.380165" waittime="1" speed="5"/>

    <panoview h="-175.559504" v="13.247107" fov="74.380165" hmin="-180" hmax="180" vmin="-90" vmax="90" fovmax="90" />
    <view fisheye="0"
          limitview="range"
          hlookatmin="-180"
          hlookatmax="180"
          vlookatmin="-90"
          vlookatmax="90"
          maxpixelzoom="1.0"
          fovmax="90"
          fov="74.380165"
          hlookat="-175.559504"
          vlookat="13.247107"/>

    <preview url="%FIRSTXML%/mainpeople_11/preview.jpg" type="CUBESTRIP" striporder="FRBLUD"/>

    <image type="CUBE" multires="true" baseindex="0" tilesize="512" devices="!androidstock|webgl">
      <level tiledimagewidth="10906" tiledimageheight="10906">
          <front url="mainpeople_11/0/4/%v_%u.jpg"/>
          <right url="mainpeople_11/1/4/%v_%u.jpg"/>
          <back  url="mainpeople_11/2/4/%v_%u.jpg"/>
          <left  url="mainpeople_11/3/4/%v_%u.jpg"/>
          <up    url="mainpeople_11/4/4/%v_%u.jpg"/>
          <down  url="mainpeople_11/5/4/%v_%u.jpg"/>
      </level>
      <level tiledimagewidth="5453" tiledimageheight="5453">
          <front url="mainpeople_11/0/3/%v_%u.jpg"/>
          <right url="mainpeople_11/1/3/%v_%u.jpg"/>
          <back  url="mainpeople_11/2/3/%v_%u.jpg"/>
          <left  url="mainpeople_11/3/3/%v_%u.jpg"/>
          <up    url="mainpeople_11/4/3/%v_%u.jpg"/>
          <down  url="mainpeople_11/5/3/%v_%u.jpg"/>
      </level>
      <level tiledimagewidth="2726" tiledimageheight="2726">
          <front url="mainpeople_11/0/2/%v_%u.jpg"/>
          <right url="mainpeople_11/1/2/%v_%u.jpg"/>
          <back  url="mainpeople_11/2/2/%v_%u.jpg"/>
          <left  url="mainpeople_11/3/2/%v_%u.jpg"/>
          <up    url="mainpeople_11/4/2/%v_%u.jpg"/>
          <down  url="mainpeople_11/5/2/%v_%u.jpg"/>
      </level>
      <level tiledimagewidth="1363" tiledimageheight="1363">
          <front url="mainpeople_11/0/1/%v_%u.jpg"/>
          <right url="mainpeople_11/1/1/%v_%u.jpg"/>
          <back  url="mainpeople_11/2/1/%v_%u.jpg"/>
          <left  url="mainpeople_11/3/1/%v_%u.jpg"/>
          <up    url="mainpeople_11/4/1/%v_%u.jpg"/>
          <down  url="mainpeople_11/5/1/%v_%u.jpg"/>
      </level>
      <level tiledimagewidth="681" tiledimageheight="681">
          <front url="mainpeople_11/0/0/%v_%u.jpg"/>
          <right url="mainpeople_11/1/0/%v_%u.jpg"/>
          <back  url="mainpeople_11/2/0/%v_%u.jpg"/>
          <left  url="mainpeople_11/3/0/%v_%u.jpg"/>
          <up    url="mainpeople_11/4/0/%v_%u.jpg"/>
          <down  url="mainpeople_11/5/0/%v_%u.jpg"/>
      </level>
    </image>
      <image type="CUBE" devices="androidstock+!webgl">
        <front url="mainpeople_11/mobile/0.jpg"/>
        <right url="mainpeople_11/mobile/1.jpg"/>
        <back  url="mainpeople_11/mobile/2.jpg"/>
        <left  url="mainpeople_11/mobile/3.jpg"/>
        <up    url="mainpeople_11/mobile/4.jpg"/>
        <down  url="mainpeople_11/mobile/5.jpg"/>
      </image>



  <!-- **** 2 Polygonal Spots **** -->

  <hotspot name="spotpolygon22"
           visible="true"
           style="PolygonDefaultPolygonSpotStyle1"
           descriptionid=""
           onclick="onclickspotpolygon22"
           ath="-115.416406" atv="2.488479"
           >
    <point ath="-118.384471" atv="-6.372015" />
    <point ath="-117.783344" atv="11.424382" />
    <point ath="-112.448341" atv="11.499791" />
    <point ath="-112.673763" atv="-6.522832" />
  </hotspot>
  <hotspot name="spotpolygon22" devices="flash" zorder="1"/>
  <hotspot name="spotpolygon22" devices="html5+desktop" zorder="3" zorder2="1"/>
  <hotspot name="spotpolygon22" devices="tablet|mobile" zorder2="1"/>
  <action name="onclickspotpolygon22">
        mainloadscene(pano19);
      lookat(-96.490008, 11.845718, 67.618332);
    
  </action>
  <hotspot name="spotpolygon55"
           visible="true"
           style="PolygonDefaultPolygonSpotStyle1"
           descriptionid=""
           onclick="onclickspotpolygon55"
           ath="-61.655611" atv="3.536872"
           >
    <point ath="-65.770459" atv="-4.523250" />
    <point ath="-57.709290" atv="-4.213246" />
    <point ath="-57.540764" atv="10.103335" />
    <point ath="-65.517670" atv="11.596994" />
  </hotspot>
  <hotspot name="spotpolygon55" devices="flash" zorder="1"/>
  <hotspot name="spotpolygon55" devices="html5+desktop" zorder="3" zorder2="1"/>
  <hotspot name="spotpolygon55" devices="tablet|mobile" zorder2="1"/>
  <action name="onclickspotpolygon55">looktohotspot(get(name),get(view.fovmin),smooth(400,20,100));
        mainloadscene(pano52);
      lookat(-52.281818, 10.554545, 81.818182);
    
  </action>
  <action name="hidepanopolygonalspots">
    set(hotspot[spotpolygon22].visible, false);
    set(hotspot[spotpolygon55].visible, false);
  </action>
  <action name="showpanopolygonalspots">
    set(hotspot[spotpolygon22].visible, true);
    set(hotspot[spotpolygon55].visible, true);
  </action>

  <!-- **** 2 Point Spots **** -->

  <hotspot name="spotpoint58"
           ath="-115.943039" atv="3.846245"
           visible="true"
           style="IconExit"
           descriptionid=""
           onclick="onclickspotpoint58"
           />
  <hotspot name="spotpoint58" devices="flash" zorder="3"/>
  <hotspot name="spotpoint58" devices="html5+desktop" zorder="3" zorder2="1"/>
  <hotspot name="spotpoint58" devices="tablet|mobile" zorder2="1"/>
  <action name="onclickspotpoint58">looktohotspot(get(name),get(view.fovmin),smooth(400,20,100));
        mainloadscene(pano19);
      lookat(-95.655597, 11.206724, 67.618332);
    
  </action>
  <hotspot name="spotpoint59"
           ath="-62.135282" atv="3.076923"
           visible="true"
           style="IconExit"
           descriptionid=""
           onclick="onclickspotpoint59"
           />
  <hotspot name="spotpoint59" devices="flash" zorder="3"/>
  <hotspot name="spotpoint59" devices="html5+desktop" zorder="3" zorder2="1"/>
  <hotspot name="spotpoint59" devices="tablet|mobile" zorder2="1"/>
  <action name="onclickspotpoint59">looktohotspot(get(name),get(view.fovmin),smooth(400,20,100));
        mainloadscene(pano52);
      lookat(-49.950000, 7.374793, 74.380165);
    
  </action>
  <action name="hidepanopointspots">
    set(hotspot[spotpoint58].visible, false);
    set(hotspot[spotpoint59].visible, false);
  </action>
  <action name="showpanopointspots">
    set(hotspot[spotpoint58].visible, true);
    set(hotspot[spotpoint59].visible, true);
  </action>


  <action name="showpanospotsaction">
    if (tour_displayspots,
    showpanopointspots();
    showpanopolygonalspots();
    );
  </action>
  <action name="hidepanospotsaction">
    hidepanopointspots();
    hidepanopolygonalspots();
  </action>

  <action name="setzorder2onstandardspots">
    if (device.html5,
      ifnot (device.desktop,

        tween(hotspot[spotpolygon22].zorder2, %1);

        tween(hotspot[spotpolygon55].zorder2, %1);


        tween(hotspot[spotpoint58].zorder2, %1, 0.5, default, copy(urlbckpspotpoint58, hotspot[spotpoint58].url); set(hotspot[spotpoint58].url, ""); copy(hotspot[spotpoint58].url, urlbckpspotpoint58););

        tween(hotspot[spotpoint59].zorder2, %1, 0.5, default, copy(urlbckpspotpoint59, hotspot[spotpoint59].url); set(hotspot[spotpoint59].url, ""); copy(hotspot[spotpoint59].url, urlbckpspotpoint59););

      );
    );
  </action>  

</scene>
  <!-- Group Group 20 : 1 panoramas -->
  

<!-- **** @PanoName="kitchenpeople_optimized_0" @PanoFile="/Volumes/Macintosh HD 3/Panoramas/Bold/kitchen people/kitchenpeople_optimized_0.jpg" **** -->
<scene name="pano19"
       heading="0"
       thumburl="%FIRSTXML%/kitchenpeople_optimi_19/thumbnail.jpg"
       backgroundsound=""
       backgroundsoundloops="0"
       titleid="pano19_title"
       descriptionid=""
       multires="true"
       planar="false"
       full360="true">

    <autorotate horizon="0.000000" tofov="90.000000" waittime="1" speed="5"/>

    <panoview h="0.000000" v="0.000000" fov="90.000000" hmin="-180" hmax="180" vmin="-90" vmax="90" fovmax="90" />
    <view fisheye="0"
          limitview="range"
          hlookatmin="-180"
          hlookatmax="180"
          vlookatmin="-90"
          vlookatmax="90"
          maxpixelzoom="1.0"
          fovmax="90"
          fov="90.000000"
          hlookat="0.000000"
          vlookat="0.000000"/>

    <preview url="%FIRSTXML%/kitchenpeople_optimi_19/preview.jpg" type="CUBESTRIP" striporder="FRBLUD"/>

    <image type="CUBE" multires="true" baseindex="0" tilesize="512" devices="!androidstock|webgl">
      <level tiledimagewidth="6035" tiledimageheight="6035">
          <front url="kitchenpeople_optimi_19/0/3/%v_%u.jpg"/>
          <right url="kitchenpeople_optimi_19/1/3/%v_%u.jpg"/>
          <back  url="kitchenpeople_optimi_19/2/3/%v_%u.jpg"/>
          <left  url="kitchenpeople_optimi_19/3/3/%v_%u.jpg"/>
          <up    url="kitchenpeople_optimi_19/4/3/%v_%u.jpg"/>
          <down  url="kitchenpeople_optimi_19/5/3/%v_%u.jpg"/>
      </level>
      <level tiledimagewidth="3017" tiledimageheight="3017">
          <front url="kitchenpeople_optimi_19/0/2/%v_%u.jpg"/>
          <right url="kitchenpeople_optimi_19/1/2/%v_%u.jpg"/>
          <back  url="kitchenpeople_optimi_19/2/2/%v_%u.jpg"/>
          <left  url="kitchenpeople_optimi_19/3/2/%v_%u.jpg"/>
          <up    url="kitchenpeople_optimi_19/4/2/%v_%u.jpg"/>
          <down  url="kitchenpeople_optimi_19/5/2/%v_%u.jpg"/>
      </level>
      <level tiledimagewidth="1508" tiledimageheight="1508">
          <front url="kitchenpeople_optimi_19/0/1/%v_%u.jpg"/>
          <right url="kitchenpeople_optimi_19/1/1/%v_%u.jpg"/>
          <back  url="kitchenpeople_optimi_19/2/1/%v_%u.jpg"/>
          <left  url="kitchenpeople_optimi_19/3/1/%v_%u.jpg"/>
          <up    url="kitchenpeople_optimi_19/4/1/%v_%u.jpg"/>
          <down  url="kitchenpeople_optimi_19/5/1/%v_%u.jpg"/>
      </level>
      <level tiledimagewidth="754" tiledimageheight="754">
          <front url="kitchenpeople_optimi_19/0/0/%v_%u.jpg"/>
          <right url="kitchenpeople_optimi_19/1/0/%v_%u.jpg"/>
          <back  url="kitchenpeople_optimi_19/2/0/%v_%u.jpg"/>
          <left  url="kitchenpeople_optimi_19/3/0/%v_%u.jpg"/>
          <up    url="kitchenpeople_optimi_19/4/0/%v_%u.jpg"/>
          <down  url="kitchenpeople_optimi_19/5/0/%v_%u.jpg"/>
      </level>
    </image>
      <image type="CUBE" devices="androidstock+!webgl">
        <front url="kitchenpeople_optimi_19/mobile/0.jpg"/>
        <right url="kitchenpeople_optimi_19/mobile/1.jpg"/>
        <back  url="kitchenpeople_optimi_19/mobile/2.jpg"/>
        <left  url="kitchenpeople_optimi_19/mobile/3.jpg"/>
        <up    url="kitchenpeople_optimi_19/mobile/4.jpg"/>
        <down  url="kitchenpeople_optimi_19/mobile/5.jpg"/>
      </image>



  <!-- **** 1 Polygonal Spots **** -->

  <hotspot name="spotpolygon23"
           visible="true"
           style="PolygonDefaultPolygonSpotStyle1"
           descriptionid=""
           onclick="onclickspotpolygon23"
           ath="63.253389" atv="2.254697"
           >
    <point ath="43.357664" atv="-36.263048" />
    <point ath="42.982273" atv="43.778706" />
    <point ath="83.149114" atv="52.045929" />
    <point ath="83.524505" atv="-47.536534" />
  </hotspot>
  <hotspot name="spotpolygon23" devices="flash" zorder="1"/>
  <hotspot name="spotpolygon23" devices="html5+desktop" zorder="3" zorder2="1"/>
  <hotspot name="spotpolygon23" devices="tablet|mobile" zorder2="1"/>
  <action name="onclickspotpolygon23">looktohotspot(get(name),get(view.fovmin),smooth(400,20,100));
        mainloadscene(pano11);
      lookat(79.311908, 7.642900, 67.618332);
    
  </action>
  <action name="hidepanopolygonalspots">
    set(hotspot[spotpolygon23].visible, false);
  </action>
  <action name="showpanopolygonalspots">
    set(hotspot[spotpolygon23].visible, true);
  </action>

  <!-- **** 1 Point Spots **** -->

  <hotspot name="spotpoint57"
           ath="73.153088" atv="10.512897"
           visible="true"
           style="IconExit"
           descriptionid=""
           onclick="onclickspotpoint57"
           />
  <hotspot name="spotpoint57" devices="flash" zorder="3"/>
  <hotspot name="spotpoint57" devices="html5+desktop" zorder="3" zorder2="1"/>
  <hotspot name="spotpoint57" devices="tablet|mobile" zorder2="1"/>
  <action name="onclickspotpoint57">looktohotspot(get(name),get(view.fovmin),smooth(400,20,100));
        mainloadscene(pano11);
      lookat(75.393641, 10.093634, 61.471211);
    
  </action>
  <action name="hidepanopointspots">
    set(hotspot[spotpoint57].visible, false);
  </action>
  <action name="showpanopointspots">
    set(hotspot[spotpoint57].visible, true);
  </action>


  <action name="showpanospotsaction">
    if (tour_displayspots,
    showpanopointspots();
    showpanopolygonalspots();
    );
  </action>
  <action name="hidepanospotsaction">
    hidepanopointspots();
    hidepanopolygonalspots();
  </action>

  <action name="setzorder2onstandardspots">
    if (device.html5,
      ifnot (device.desktop,

        tween(hotspot[spotpolygon23].zorder2, %1);


        tween(hotspot[spotpoint57].zorder2, %1, 0.5, default, copy(urlbckpspotpoint57, hotspot[spotpoint57].url); set(hotspot[spotpoint57].url, ""); copy(hotspot[spotpoint57].url, urlbckpspotpoint57););

      );
    );
  </action>  

</scene>
  <!-- Group Group 53 : 1 panoramas -->
  

<!-- **** @PanoName="warroom_moody" @PanoFile="/Volumes/Macintosh HD 3/Panoramas/Bold/warroom moody/cubefaces/warroom_moody_0.jpg" **** -->
<scene name="pano52"
       heading="0"
       thumburl="%FIRSTXML%/warroom_moody_52/thumbnail.jpg"
       backgroundsound=""
       backgroundsoundloops="0"
       titleid="pano52_title"
       descriptionid=""
       multires="true"
       planar="false"
       full360="true">

    <autorotate horizon="0.000000" tofov="90.000000" waittime="1" speed="5"/>

    <panoview h="0.000000" v="0.000000" fov="90.000000" hmin="-180" hmax="180" vmin="-90" vmax="90" fovmax="90" />
    <view fisheye="0"
          limitview="range"
          hlookatmin="-180"
          hlookatmax="180"
          vlookatmin="-90"
          vlookatmax="90"
          maxpixelzoom="1.0"
          fovmax="90"
          fov="90.000000"
          hlookat="0.000000"
          vlookat="0.000000"/>

    <preview url="%FIRSTXML%/warroom_moody_52/preview.jpg" type="CUBESTRIP" striporder="FRBLUD"/>

    <image type="CUBE" multires="true" baseindex="0" tilesize="512" devices="!androidstock|webgl">
      <level tiledimagewidth="6044" tiledimageheight="6044">
          <front url="warroom_moody_52/0/3/%v_%u.jpg"/>
          <right url="warroom_moody_52/1/3/%v_%u.jpg"/>
          <back  url="warroom_moody_52/2/3/%v_%u.jpg"/>
          <left  url="warroom_moody_52/3/3/%v_%u.jpg"/>
          <up    url="warroom_moody_52/4/3/%v_%u.jpg"/>
          <down  url="warroom_moody_52/5/3/%v_%u.jpg"/>
      </level>
      <level tiledimagewidth="3022" tiledimageheight="3022">
          <front url="warroom_moody_52/0/2/%v_%u.jpg"/>
          <right url="warroom_moody_52/1/2/%v_%u.jpg"/>
          <back  url="warroom_moody_52/2/2/%v_%u.jpg"/>
          <left  url="warroom_moody_52/3/2/%v_%u.jpg"/>
          <up    url="warroom_moody_52/4/2/%v_%u.jpg"/>
          <down  url="warroom_moody_52/5/2/%v_%u.jpg"/>
      </level>
      <level tiledimagewidth="1511" tiledimageheight="1511">
          <front url="warroom_moody_52/0/1/%v_%u.jpg"/>
          <right url="warroom_moody_52/1/1/%v_%u.jpg"/>
          <back  url="warroom_moody_52/2/1/%v_%u.jpg"/>
          <left  url="warroom_moody_52/3/1/%v_%u.jpg"/>
          <up    url="warroom_moody_52/4/1/%v_%u.jpg"/>
          <down  url="warroom_moody_52/5/1/%v_%u.jpg"/>
      </level>
      <level tiledimagewidth="755" tiledimageheight="755">
          <front url="warroom_moody_52/0/0/%v_%u.jpg"/>
          <right url="warroom_moody_52/1/0/%v_%u.jpg"/>
          <back  url="warroom_moody_52/2/0/%v_%u.jpg"/>
          <left  url="warroom_moody_52/3/0/%v_%u.jpg"/>
          <up    url="warroom_moody_52/4/0/%v_%u.jpg"/>
          <down  url="warroom_moody_52/5/0/%v_%u.jpg"/>
      </level>
    </image>
      <image type="CUBE" devices="androidstock+!webgl">
        <front url="warroom_moody_52/mobile/0.jpg"/>
        <right url="warroom_moody_52/mobile/1.jpg"/>
        <back  url="warroom_moody_52/mobile/2.jpg"/>
        <left  url="warroom_moody_52/mobile/3.jpg"/>
        <up    url="warroom_moody_52/mobile/4.jpg"/>
        <down  url="warroom_moody_52/mobile/5.jpg"/>
      </image>



  <!-- **** 1 Polygonal Spots **** -->

  <hotspot name="spotpolygon54"
           visible="true"
           style="PolygonDefaultPolygonSpotStyle1"
           descriptionid=""
           onclick="onclickspotpolygon54"
           ath="125.225049" atv="0.529931"
           >
    <point ath="112.896282" atv="-14.514230" />
    <point ath="137.495108" atv="-14.690873" />
    <point ath="137.553816" atv="14.396467" />
    <point ath="127.162427" atv="14.808636" />
    <point ath="115.127202" atv="14.396467" />
    <point ath="113.013699" atv="15.750736" />
  </hotspot>
  <hotspot name="spotpolygon54" devices="flash" zorder="1"/>
  <hotspot name="spotpolygon54" devices="html5+desktop" zorder="3" zorder2="1"/>
  <hotspot name="spotpolygon54" devices="tablet|mobile" zorder2="1"/>
  <action name="onclickspotpolygon54">looktohotspot(get(name),get(view.fovmin),smooth(400,20,100));
        mainloadscene(pano11);
      lookat(78.006198, 7.471488, 74.380165);
    
  </action>
  <action name="hidepanopolygonalspots">
    set(hotspot[spotpolygon54].visible, false);
  </action>
  <action name="showpanopolygonalspots">
    set(hotspot[spotpolygon54].visible, true);
  </action>

  <!-- **** 1 Point Spots **** -->

  <hotspot name="spotpoint60"
           ath="119.426751" atv="7.364520"
           visible="true"
           style="IconExit"
           descriptionid=""
           onclick="onclickspotpoint60"
           />
  <hotspot name="spotpoint60" devices="flash" zorder="3"/>
  <hotspot name="spotpoint60" devices="html5+desktop" zorder="3" zorder2="1"/>
  <hotspot name="spotpoint60" devices="tablet|mobile" zorder2="1"/>
  <action name="onclickspotpoint60">looktohotspot(get(name),get(view.fovmin),smooth(400,20,100));
        mainloadscene(pano11);
      lookat(74.019760, 14.700902, 67.618332);
    
  </action>
  <action name="hidepanopointspots">
    set(hotspot[spotpoint60].visible, false);
  </action>
  <action name="showpanopointspots">
    set(hotspot[spotpoint60].visible, true);
  </action>


  <action name="showpanospotsaction">
    if (tour_displayspots,
    showpanopointspots();
    showpanopolygonalspots();
    );
  </action>
  <action name="hidepanospotsaction">
    hidepanopointspots();
    hidepanopolygonalspots();
  </action>

  <action name="setzorder2onstandardspots">
    if (device.html5,
      ifnot (device.desktop,

        tween(hotspot[spotpolygon54].zorder2, %1);


        tween(hotspot[spotpoint60].zorder2, %1, 0.5, default, copy(urlbckpspotpoint60, hotspot[spotpoint60].url); set(hotspot[spotpoint60].url, ""); copy(hotspot[spotpoint60].url, urlbckpspotpoint60););

      );
    );
  </action>  

</scene>



</krpano>';

echo $xml;