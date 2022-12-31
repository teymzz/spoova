function loadFile(elem, parent, infopane){
  /*
    attributes  :  function
    data-size   => set file size
    data-accept => set valid types (jpg,pdf,...)
    data-strict => enforce value restriction
    data-status => returns upload status
    data-msg    => return status message
    data-load   => (image, image-strict, im-strict-sz) //for media autoload and restriction

    src-attrs  : function
    data-bg     => set success image bgColor

  */
  
  var inputValue, fileName, fileTypes, dataStrict, dataTypes, dataSize, dataLoad, dataStatus, dataMsg, parentcover, isLarge;

  if(elem != null && parent != null){
     //elem = item, item = parent, infopane = content pane
     var parentcover = $(elem).closest(parent);
     var inputFile   = parentcover.find("input[type='file']");

     inputFile.click();

     inputFile.on('change',function(event){
      event.stopImmediatePropagation();
      //initialize input file
      inputFile.removeAttr('data-msg data-status')

      //console.log('---- item called -----');

      //default variables
      var dataValid  = false;
      var makeswitch = false;

      //accepted dataLoad options
      var imOptions  = ['image','im','image-strict','im-strict','imsize-strict','im-strict-sz'];
      var viOptions  = ['video','vid','video-strict','vid-strict','vidsize-strict','vid-strict-sz'];      
      
      //data settings      
      dataStrict = hasAttr(inputFile,'data-strict');
      dataSize   = !isNaN(inputFile.data('size'))? parseInt(inputFile.data('size')) : 200; //in kilobytes
      dataLoad   = inputFile.data('load') || 'file'; // video, picture, other files  

      dataTypes = inputFile.attr('data-accept') || '*'; 
      dataTypes = dataTypes.toLowerCase();
      fileTypes = dataTypes.split(",");
      fileTypes.includes('jpeg')? fileTypes.push('jpg') : '';

      //file information
      inputValue = inputFile.val();
      var inputInfo  = inputFile[0].files[0];
      var extDot     = inputValue.lastIndexOf(".")+1;
      
      fileName = inputValue.lastIndexOf("\\")+1;
      fileName = inputValue.substr(fileName,inputValue.length).toLowerCase();
      
      fileExt  = inputValue.substr(extDot,inputValue.length).toLowerCase();
      fileSize = inputInfo.size / 1000; 
      fileType = inputInfo.type;
      isLarge  = (fileSize > dataSize) ? true : false;

      if(infopane != null){ parentcover.find(infopane).val(fileName); } //add filename to dummy field
      
      setTimeout(function() {
        //start onchange processing 
        if(dataLoad === 'file'){
          //data-strict, data-accept

          if(fileTypes.includes('*') || fileTypes.includes(fileExt)){
            if(!isLarge){
              dataStatus = 'success';
              inputFile.attr({'data-status':dataStatus});
              dataValid = true; 
            }else{
              dataStatus = 'failed';
              dataMsg = 'file too large!';
              inputFile.attr({'data-status':'failed'}); 
              inputFile.attr({'data-msg':dataMsg}); 
              dataStrict ? inputFile.val('') : ''; 
            }
          }else{
            dataStatus = 'failed';
            dataMsg = 'invalid file!';
            inputFile.attr({'data-status':'failed'}); 
            inputFile.attr({'data-msg':dataMsg}); 
            dataStrict ? inputFile.val('') : '';          
          }
        }else if(imOptions.includes(dataLoad) || viOptions.includes(dataLoad)){
          //process and load media files

          var isimField  = (imOptions.includes(dataLoad))? true : false; 
          var isvidField = (viOptions.includes(dataLoad))? true : false;

          //check for media file
          var isImage = (fileType.split('/')[0] == 'image')? true : false;
          var isVideo = (fileType.split('/')[0] == 'video')? true : false; 
          var isOFile = (!isImage && !isVideo)? true : false;

          if(isimField){

            //image load settings
            var imageBox, bgColor, srcAttr, imDefault, loadImage, loadImageStrict, loadSizeStrict, loadImageStrictSize;

            loadImage = (dataLoad == 'image' || dataLoad == 'im')? true : false;  //simple change 
            loadImageStrict = (dataLoad == 'image-strict' || dataLoad == 'im-strict')? true : false;  //change only valid images    
            loadSizeStrict = (dataLoad == 'imsize-strict' || dataLoad == 'strict-sz')? true : false;  //change only valid size      
            loadImageStrictSize = (dataLoad == 'im-strict-sz')? true : false;  //change only valid size and image

            if(loadImage){ makeswitch = true; } //simple load
            if(loadImageStrict && fileTypes.includes(fileExt)){ makeswitch = true; } //restrict image loading
            if(loadSizeStrict  && !isLarge){ makeswitch = true; } //restrict size loading
            if(loadImageStrictSize  && fileTypes.includes(fileExt) && !isLarge){ makeswitch = true; } //restrict image and size loading

            //control field response
            if((isImage && fileTypes.includes('*')) || (isImage && fileTypes.includes(fileExt))){
               if(!isLarge){
                dataStatus = 'success';
                dataMsg = '';
                inputFile.attr({'data-status':dataStatus});
                dataValid = true;
               }else{
                //error: large file
                dataStatus = 'failed';
                dataMsg = 'large file!';
                inputFile.attr({'data-status':'failed'}); 
                inputFile.attr({'data-msg':dataMsg}); 
                dataStrict ? inputFile.val('') : '';              
               }
            }else{
              //error: invalid file
              dataStatus = 'failed';
              dataMsg = 'invalid file!';
              inputFile.attr({'data-status':'failed'}); 
              inputFile.attr({'data-msg':dataMsg}); 
              dataStrict ? inputFile.val('') : '';             
            }

            //get image field area
            if(parentcover.find("[data-src]").length > 0){
                imageBox  = parentcover.find("[data-src]")
                srcAttr   = "data-src";
                imDefault = imageBox.attr('data-src') || null;
                bgColor   = imageBox.data("bg");
            }else{
                imageBox = null
            }

            //control load response
            if(makeswitch === true && (imageBox != null)){
              imageBox.attr({"data-status":dataStatus}).attr({"data-msg":dataMsg}).attr("title",fileName);

              if(inputFile.val() != ''){
                var reader = new FileReader();

                reader.onload=function(event){
                        imageBox.css("background-image","url("+reader.result+")").attr("title",fileName).addClass("tmp-image");
                        if(bgColor){ output.css("background-color",bgColor) };
                }

                reader.readAsDataURL(event.target.files[0]);
              }else{
                 imageBox.css("background-image","url("+reader.result+")").attr("title",fileName).addClass("tmp-image");
                 if(bgColor){ output.css("background-color",bgColor) };
              }
              
            }else{
              if(imageBox != null){
                imDefault = imageBox.attr(srcAttr) || imageDefault;
                if(imDefault != null){ 
                  imageBox.css({"background-image":'url('+imDefault+')'}); 
                }else{
                  imageBox.css({"background-image":'unset'})
                }
                imageBox.attr({"data-status":dataStatus,"data-msg":dataMsg}).removeAttr("title").removeClass("tmp-image");
              }
            }

          }

          if(isvidField){

            //set default varaibles
            var videoBox, bgColor, vidDefault, loadVideo, loadVideoStrict, loadSizeStrict, loadVideoStrictSize;

            loadVideo = (dataLoad == 'video' || dataLoad == 'vid')? true : false;  //simple change 
            loadVideoStrict = (dataLoad == 'video-strict' || dataLoad == 'vid-strict')? true : false;  //change only valid video    
            loadSizeStrict = (dataLoad == 'vidsize-strict')? true : false;  //change only valid size      
            loadVideoStrictSize = (dataLoad == 'vid-strict-sz')? true : false;  //change only valid size and video  
            
            //restrict load option
            if(loadVideo){ makeswitch = true; } //simple load
            if(loadVideoStrict  && fileTypes.includes(fileExt)){ makeswitch = true; } //restrict image loading
            if(loadSizeStrict  && !isLarge){ makeswitch = true; } //restrict size loading
            if(loadVideoStrictSize  && fileTypes.includes(fileExt) && !isLarge){ makeswitch = true; } //restrict image and size loading   

            //select video area
            if(parentcover.find("[data-vsrc]").length > 0){
              videoBox  = parentcover.find("[data-vsrc]");
              vidLen    = videoBox.length;
            }else if(parentcover.find("[vsrc]").length > 0){
              videoBox  = parentcover.find("[vsrc]");
              vidLen    = videoBox.length;
            }


            if(vidLen > 0){
              //get tag
              var vidTag, realSource, autoplay, loadIcon, dPoster, hasdPoster, poster, video, duration, isLoad = false;

              autoplay = inputFile.data('autoplay');
              vidTag   = videoBox.prop('tagName').toLowerCase();
              loadIcon = videoBox.data('loadicon') || false;
              poster   = videoBox.attr('data-poster') || videoBox.attr('poster'); 

              //reset declared attributes
              parentcover.removeAttr('data-success');
              videoBox.attr({'type':'','title':''}).removeAttr('data-status data-msg poster').removeClass("tmp-video");

              if((makeswitch == true) && (videoBox != null)){

                //change the background loading icon
                if(loadIcon){
                  videoBox.attr({'data-poster':poster}).css({'background-image':'url('+loadIcon+')'});
                }

                if(videoBox.find('source').length > 0){ 
                      videoBox.find('source').remove(); //remove old source
                      videoBox.get(0).load();
                } 

                var reader = new FileReader();
                
                reader.onload=function(event){

                  if(vidTag == 'iframe' || vidTag == 'embed'){
                    videoBox.attr({'src':reader.result}).attr({'title':fileName}).addClass("tmp-video");
                  }

                  if(vidTag == 'object'){
                    videoBox.attr({'data':reader.result,'type':fileType,'title':fileName}).addClass("tmp-video");
                  }

                  if(vidTag == 'video'){

                    if(videoBox.find('source').length > 0){ 
                      videoBox.find('source').remove(); //remove old source
                    } 

                    realSource = $('<source>'); //new source
                    realSource.attr({'src': URL.createObjectURL(inputInfo)})

                    //change the background back
                    videoBox.attr({'poster':''});

                    setTimeout(function() {
                      $(videoBox).append(realSource);

                      video = $(videoBox).get(0); 
                      video.load();

                      var checker = function(){ 
                        if(video.readyState === 4){

                          (loadIcon)? videoBox.css({'background-image':''}) : '';

                          var duration = Math.round(video.duration);
                          var buffered = Math.round(video.buffered.end(0));
                          var percent  = Math.round(100 * buffered / duration);
                      
                          // console.log(percent);
                          if(buffered >= duration || percent == 100){
                            parentcover.attr({'data-success':''});
                            videoBox.attr({"title":fileName,"data-status":dataStatus,"data-msg":dataMsg,'type':fileType}).addClass("tmp-video");
                            if(autoplay === true){ video.play(); }
                            clearInterval(checkload);
                          }
                        }
                      }
                      var checkload = setInterval(checker,500);
                    }, 3000);

                  }


                }              
                reader.readAsDataURL(event.target.files[0]);
                
              }else{
                if(vidTag == 'video'){
                  realSource = videoBox.find('source');
                  realSource.attr({"src":''});
                  videoBox.removeAttr("title data-status data-msg").removeClass("tmp-video");
                  videoBox.get(0).load();
                }else{
                  videoBox.attr({'src':''}).removeAttr("title data-status data-msg").removeClass("tmp-video");
                }
                if(videoBox.data('loadicon')){
                  videoBox.attr({'poster':''}).removeAttr('data-poster');
                  videoBox.attr({'poster':poster})
                }
              }
            }
          }

        }
      }, 10);

     })


  }else{
    var parentcover= $(elem).parent(); 
    var inputFile  = parentcover.find("input[type='file']");
    inputFile.click();    
  }

}  // for input browse in forms