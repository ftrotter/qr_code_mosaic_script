<?php

        if(!isset($argv[3])){
                echo "The first argument of this script is the QR code file
The second argument is the image file.
The third argument is the output file\n";
                exit();
        }

        $qr_code_img = $argv[1];
        $overlay_img = $argv[2];
        $output_img = $argv[3];

/*
        //there should no output file
        if(file_exists($output_img)){
                echo "output_img:$output_img already exists... delete it\n";
                exit();
        }
*/
        //there should be a qr code file
        if(!file_exists($qr_code_img)){
                echo "qr_code_img:$qr_code_img does not exist\n";
                exit();
        }

        //there should be a overlay file
        if(!file_exists($overlay_img)){
                echo "overlay_img:$overlay_img does not exist\n";
                exit();
        }

        $qr_size = getimagesize($qr_code_img);
        $qr_width = $qr_size[0];
        $qr_height = $qr_size[0];

        $over_size = getimagesize($qr_code_img);
        $over_width = $over_size[0];
        $over_height = $over_size[0];

        $width_diff = abs($over_width - $qr_width);
        $height_diff = abs($over_height - $qr_height);

        if($width_diff > 10 || $height_diff > 10){
                echo "You need to have a qr code and overlay of the same size!!\n";
                echo "qr_width:$qr_width qr_height:$qr_height over_width:$over_width over_height:$over_height\n";
                exit();
        }


        //make the edges of the qr code... we will need this later...
        $edge_cmd = "convert $qr_code_img -edge 1 -negate _tmp_edge.png ";
        exec($edge_cmd);

        //make the overlay without edges...
        $img_cmd = "convert $qr_code_img -size $over_width"."x$over_height tile:$overlay_img -compose Screen -composite _tmp_no_edge_over.png";
        exec($img_cmd);

        //merge the overlay and the edges... and increase the brightness and contrast a little..
        $final_cmd = "convert -brightness-contrast 10x20 _tmp_no_edge_over.png -size $over_width"."x$over_height tile:_tmp_edge.png -compose Multiply -composite _tmp_with_edges.png";
        exec($final_cmd);

        //now blend the original qr code (which is black everywhere, something we cannot say for our overlay...)
        $mean_cmd = "composite -blend 50 $qr_code_img _tmp_with_edges.png $output_img";
        exec($mean_cmd);

        //clean up by deleting temporary files
        $do_cleanup = true; //you can change this to see intermediate states..
        if($do_cleanup){
                unlink('_tmp_edge.png');
                unlink('_tmp_no_edge_over.png');
                unlink('_tmp_with_edges.png');
        }
