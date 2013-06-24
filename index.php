<?php
$now = new DateTime();


$brightnessM = `cat brightness1`;
$brightnessV = `cat brightness0`;
$status = "";
$favico = "images/geenkel.ico";

if ($brightnessM > 0) {
    $statusM = "occupado";
    $favico = "images/herr.ico";
}

if ($brightnessV > 0) {
    $statusV = "occupado";
    
    if($statusM == "occupado"){
        $favico = "images/allezwei.ico";
    }else{
        $favico = "images/fraulein.ico";
    }
}

$timeM = new DateTime(`cat timestamp1`);
$timeV = new DateTime(`cat timestamp0`);
?>
<!DOCTYPE html>
<html>
    <head>
        <meta charset="utf-8" />
        <!-- Always force latest IE rendering engine (even in intranet) & Chrome Frame
        Remove this if you use the .htaccess -->
        <meta http-equiv="X-UA-Compatible" content="IE=edge,chrome=1" />
        <meta name="keywords" content="" />
        <meta name="description" content="" />
        <meta name="author" content="intracto" />
        <meta name="viewport" content="width=device-width, initial-scale=1.0, maximum-scale=1.0, user-scalable=no" />
        <title>Flush</title>
        <!-- Replace favicon.ico & apple-touch-icon.png in the root of your domain and delete these references -->
        <link rel="shortcut icon" href="<?php echo $favico; ?>" />
        <link rel="apple-touch-icon" href="images/apple-touch-icon.png" />		
        <link rel="stylesheet" href="css/style.css" />
        <script src="//ajax.googleapis.com/ajax/libs/jquery/1.8.3/jquery.min.js"></script>
        <script src="http://ricostacruz.com/jquery.transit/jquery.transit.min.js"></script>

        <!--[if IE 6]>
                <link href="css/csshover.css" rel="stylesheet" type="text/css" />
                <script src="js/DD_belatedPNG.js" type="text/javascript"></script>
                <script type="text/javascript">
                /* <![CDATA[ */
                        DD_belatedPNG.fix('h2,div,img,a,li,ul,span,input,form');
                 /* ]]> */
                </script>
        <![endif]-->
        <!--[if lt IE 9]>
                <script src="js/html5shim.js"></script>
        <![endif]-->
    </head>
    <body>

        <div id="container" class="clearfix">
            <div id="heren">
                <div class="icon <?php echo $statusM; ?>">
                    <img src="images/man.png">
                    <img src="images/man_active.png" class="active <?php echo $statusM; ?>">
                </div>
                <div class="status"><?php
if ($brightnessM > 0) {
    echo 'ocupado <div class="time">' . $timeM->format("H:i") . '</div>';
} else {
    echo 'libre';
}
?></div>
            </div>
            <div id="dames">
                <div class="icon <?php echo $statusV; ?>">
                    <img src="images/vrouw.png">
                    <img src="images/vrouw_active.png" class="active <?php echo $statusV; ?>">
                </div>
                <div class="status"><?php
if ($brightnessV > 0) {
    echo 'ocupado <div class="time">' . $timeV->format("H:i") . '</div>';
} else {
    echo 'libre';
}
?></div>
            </div>
        </div>

        <script type="text/javascript">
            /* <![CDATA[ */
            // content of your Javascript goes here
            $(document).ready(function(){
                var man_bezet = <?php
                    if ($brightnessM > 0) {
                        echo '1';
                    } else {
                        echo '0';
                    };
?>;
   var vrouw_bezet = <?php
                    if ($brightnessV > 0) {
                        echo '1';
                    } else {
                        echo '0';
                    };
?>;
                
        setInterval(function() {
            $.ajax({
                url: "ajax.php"
            }).done(function ( data ) {
                  
                data = eval("(["+data+"])");
                        
                if(data.length>0){
                    console.log(data);
		   // set heren state
                    if(data[0][1].state=="0" && man_bezet == 1){
                        $('#heren .icon').transition({ scale: 0.815 },1000);
                        $('#heren .active').transition({ opacity: 0 },1000);
                        $('#heren .status').text("libre");
                        man_bezet = 0;
                                
                        changeFavicon('images/geenkel.ico');
                    }else if(data[0][1].state=="1" && man_bezet == 0){
                        $('#heren .icon').transition({ scale: 1 },1000);
                        $('#heren .active').transition({ opacity: 1 },1000);
                        $('#heren .status').html("ocupado<div class=\"time\">"+data[0][1].timestamp+"</div>");
                        man_bezet = 1;
                                
                        changeFavicon('images/herr.ico');
                    }
		    //set ladystate
                    if(data[0][0].state=="0" && vrouw_bezet == 1){
                        $('#dames .icon').transition({ scale: 0.815 },1000);
                        $('#dames .active').transition({ opacity: 0 },1000);
                        $('#dames .status').text("libre");
                        vrouw_bezet = 0;
                        
                        if(man_bezet){
                            changeFavicon('images/herr.ico');
                        }else{
                            changeFavicon('images/geenkel.ico');
                        }
                        
                        
                    }else if(data[0][0].state=="1" && vrouw_bezet == 0){
                        $('#dames .icon').transition({ scale: 1 },1000);
                        $('#dames .active').transition({ opacity: 1 },1000);
                        $('#dames .status').html("ocupado<div class=\"time\">"+data[0][0].timestamp+"</div>");
                        vrouw_bezet = 1;
                                
                         if(man_bezet){
                            changeFavicon('images/allezwei.ico');
                        }else{
                            changeFavicon('images/fraulein.ico');
                        }
                    }
                }
            });},5000);
                    
        function changeFavicon(url){
            var link = document.createElement('link'),
            oldLink = document.getElementById('dynamic-favicon');
            link.id = 'dynamic-favicon';
            link.rel = 'shortcut icon';
            link.href = url;
            if (oldLink) {
                document.head.removeChild(oldLink);
            }
            document.head.appendChild(link);
        }
                    
    });
    /* ]]> */
        </script> 

    </body>
</html>
