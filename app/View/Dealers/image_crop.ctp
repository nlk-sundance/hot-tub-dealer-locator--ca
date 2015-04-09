
    <script src="https://ajax.googleapis.com/ajax/libs/prototype/1.7.0.0/prototype.js" type="text/javascript"></script>
        <script src="https://ajax.googleapis.com/ajax/libs/scriptaculous/1.9.0/scriptaculous.js" type="text/javascript"></script>
  <script src="<?php echo $this->webroot;?>js/cropper/cropper.js" type="text/javascript"></script>

    <script type="text/javascript" charset="utf-8">
        function onEndCrop( coords, dimensions ) {
            $( 'DealerX1' ).value = coords.x1;
            $( 'DealerY1' ).value = coords.y1;
            //$( 'x2' ).value = coords.x2;
            //$( 'y2' ).value = coords.y2;
            $( 'DealerWidth' ).value = dimensions.width;
            $( 'DealerHeight' ).value = dimensions.height;
        }
        
        // example with a preview of crop results, must have minimumm dimensions
        Event.observe( 
            window, 
            'load', 
            function() { 
                new Cropper.ImgWithPreview( 
                    'testImage',
                    { 
                        minWidth: <?php echo $width;?>, 
                        minHeight: <?php echo $height;?>,
                        ratioDim: { x: <?php echo $width;?>, y: <?php echo $height;?> },
                        displayOnInit: true, 
                        onEndCrop: onEndCrop,
                        previewWrap: 'previewArea'
                    } 
                ) 
            } 
        );
    </script>
    <style type="text/css">
        label { 
            clear: left;
            margin-left: 50px;
            
            width: 5em;
        }
        
        #testWrap {
            width: 500px;
            
            margin: 10px 0 20px 20px; /* Just while testing, to make sure we return the correct positions for the image & not the window */
        }
        
        #previewArea {
            margin: 10px 0 0 20px;
            
        }
        
        #results {
            clear: both;
        }
    </style>
    <h2>Crop <?php echo ucfirst($type);?> Image <?php echo basename($image);?></h2>
    <div id="testWrap">
        <img src="<?php echo $this->webroot;?>files/dealer_imgs/<?php echo $image;?>" alt="test image" id="testImage" />
    </div>
    <h3>Preview Resized Image</h3>
    <div id="previewArea"></div>
    
    <div id="results">
        <?php echo $this->Form->create();
        echo $this->Form->hidden('x1');
        echo $this->Form->hidden('y1');
        echo $this->Form->hidden('width');
        echo $this->Form->hidden('height');?>
        <div class="form-bottom">
            <input type="submit" value="Save" />
            <input type="button" value="Cancel" onclick="window.location = '<?php echo $this->Html->url('/dealers'); ?>';" />
        </div>
        <?php echo $this->Form->end();?>
    </div> 
    
</body>
</html>


