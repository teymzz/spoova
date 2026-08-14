import { SPAuto } from "./autoload/SPAuto.js";
import { SScripts } from "./autoload/SScripts.js";
import SSDom from "./autoload/SSDom.js";

/**
 * Spoova module for managing input file.
 */
export class LoadFile {

  
  /*
    Attributes  .: Description
    data-pow    => sets file size conversion power 1024 or 1000 only
    data-size   => set file size
    data-accept => set valid types (jpg,pdf,...)
    data-strict => enforce value restriction
    data-status => returns upload status
    data-msg    => return status message
    data-load   => (image, image-strict, im-strict-sz) //for media autoload and restriction
  */

  constructor(elem, parent, infopane) {
    SScripts.requires('helper');
    this.elem = elem;
    this.root = new SSDom(elem);
    this.parentSelector = parent;
    this.infopane = infopane;
    this.handle();
  }

  handle() {
    if (!this.root.exists()) return; // Ensure a root file exists.

    let parentCover, inputFile, isAttributed = false;

    if(this.elem != null && this.parentSelector != null){
      parentCover = this.root.closest(this.parentSelector);
      inputFile = parentCover.find("input[type='file']");
    }else{
      parentCover = this.root.parent();
      inputFile = parentCover.find("input[type='file']");
      isAttributed = true;
      if(inputFile.exists()) inputFile.click();
    }

    if(isAttributed || !inputFile.exists()) return;

    if(this.elem != null && this.parentSelector != null){

      if (!inputFile.exists()) return;
  
      inputFile.click();
  
      inputFile.on('change', (event) => {

        event.stopImmediatePropagation?.();
        inputFile.removeAttr('data-msg', 'data-status');
  
        const onmod = inputFile.data('mod');
        const hasCallback = onmod && typeof window[onmod] === 'function';

        const inputElement = inputFile.get();
        const file = inputElement.files[0];

        // define data settings
        const dataLoad = inputFile.data('load') || 'file';
        let dataTypes = (inputFile.attr('data-accept') || '*');
        let fileTypes = dataTypes.toLowerCase().split(',');
        fileTypes.includes('jpeg')? fileTypes.push('jpg') : '';
        const dataStrict = inputFile.hasAttr('data-strict');
        const dataSize = parseInt(inputFile.data('size')) || 200;

        if(file){
          
          let dataPower;

          dataPower = parseInt(inputFile.data('pow'));
          dataPower = [1000, 1024].includes(dataPower)? dataPower : 1000; //defaults as 1000
          
          const value = inputElement.value;
          const fileName = value.split(/\\|\//).pop().toLowerCase();
          const fileExt = fileName.split('.').pop();
          const fileSize = file.size / dataPower;
          const fileType = file.type;
  
          function formatBytes(bytes, power, decimals = 2) {
            if (!+bytes) return '0 Bytes';
  
            const units = ['Bytes', 'KB', 'MB', 'GB', 'TB'];
            const i = Math.floor(Math.log(bytes) / Math.log(power));
            const size = parseFloat((bytes / Math.pow(power, i)).toFixed(decimals));
  
            return `${size} ${units[i]}`;
          }
  
          const sizeString = formatBytes(file.size, dataPower); 
          
          const isLarge = fileSize > dataSize;
    
          if (this.infopane) {
            parentCover.find(this.infopane).val(fileName);
          }
    
          // accepted data-load options
          const imOptions = ['image','im','image-strict','im-strict','imsize-strict','im-strict-sz'];
          const viOptions = ['video','vid','video-strict','vid-strict','vidsize-strict','vid-strict-sz'];
    
          let dataStatus = 'failed'; // default
          let dataMsg = 'something is wrong'; // default
          let makeswitch = false;
    
          setTimeout(function() {
              //start onchange processing
                
              //check for media file
              let isImage = fileType.startsWith('image');
              let isVideo = fileType.startsWith('video'); 
              let isMedia = (isImage || isVideo); 
              let isOFile = (!isImage && !isVideo); // is other file type 
    
              if((dataLoad === 'file' && (fileTypes.includes('*') || fileTypes.includes(fileExt)))
                 || (isMedia && fileTypes.includes('*')) || (isMedia && fileTypes.includes(fileExt)))
              {
                if(!isLarge){
                  dataStatus = 'success';
                  dataMsg = '';
                  inputFile.attr({'data-status':dataStatus});
                }else{
                  dataStatus = 'failed';
                  dataMsg = (isOFile? 'file' : 'media') + ' too large!';
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

              if(dataLoad === 'file'){
                //data-strict, data-accept
  
                if(hasCallback) {
                  window[onmod](Object.freeze({
                    picker: inputFile.get(0), // file picker
                    mediaTag: inputFile.prop('tagName').toLowerCase(), 
                    viewBox: null,
                    strict: dataStrict,
                    input: {
                      value : inputFile.val(), // input value
                      name: fileName, 
                      ext: fileExt,
                      maxSize: dataSize,
                      size: fileSize, 
                      sizeString: sizeString, 
                      type: fileType,
                      class: 'file',
                      msg: dataMsg,
                      success: dataStatus === 'success', 
                    },
                    status: dataStatus, 
                  }));
                }
  
              }else if(imOptions.includes(dataLoad) || viOptions.includes(dataLoad)){
                //process and load media files
    
                var isimField  = (imOptions.includes(dataLoad))? true : false; 
                var isvidField = (viOptions.includes(dataLoad))? true : false;
    
                if(isimField){
    
                  //image load settings
                  var imageBox, srcAttr, imDefault, loadImage, loadImageStrict, loadSizeStrict, loadImageStrictSize;
    
                  loadImage = (dataLoad == 'image' || dataLoad == 'im')? true : false;  //simple change 
                  loadImageStrict = (dataLoad == 'image-strict' || dataLoad == 'im-strict')? true : false;  //change only valid images    
                  loadSizeStrict = (dataLoad == 'imsize-strict' || dataLoad == 'strict-sz')? true : false;  //change only valid size      
                  loadImageStrictSize = (dataLoad == 'im-strict-sz')? true : false;  //change only valid size and image
    
                  if(loadImage){ makeswitch = true; } //simple load
                  if(loadImageStrict && fileTypes.includes(fileExt)){ makeswitch = true; } //restrict image loading
                  if(loadSizeStrict  && !isLarge){ makeswitch = true; } //restrict size loading
                  if(loadImageStrictSize  && fileTypes.includes(fileExt) && !isLarge){ makeswitch = true; } //restrict image and size loading
    
                  //control field response
    
                  //get image field area
                  if(parentCover.find("[data-src]").length > 0){
                      imageBox  = parentCover.find("[data-src]")
                      srcAttr   = "data-src";
                      imDefault = imageBox.attr('data-src') || null;
                  }else{
                      imageBox = null
                  }
    
                  //control load response
                  if(makeswitch === true && (imageBox != null)){ 
                    imageBox.attr({"data-status":dataStatus}).attr({"data-msg":dataMsg}).attr("title",fileName);
    
                    if(inputFile.val() != ''){
                      var reader = new FileReader();
                      
                      reader.onload=function(event){
                          if(imageBox.prop('tagName').toLowerCase() === 'img'){
                          imageBox.get(0).src =  reader.result;
                          }else{
                          imageBox.css("background-image","url("+reader.result+")");
                          }
                        imageBox.attr("title",fileName).addClass("tmp-image");
                      }
    
                      reader.readAsDataURL(event.target.files[0]);
                    }else{
                      if(imageBox.prop('tagName').toLowerCase() === 'img'){
                        imageBox.get(0).src =  reader.result;
                      }else{
                        imageBox.css("background-image","url("+reader.result+")")
                      }
                      imageBox.attr("title",fileName).addClass("tmp-image");
                    }
                    
                  }else{
                    if(imageBox != null){
                      imDefault = imageBox.attr(srcAttr) || imDefault;
                      if(imDefault != null){ 
                        imageBox.css({"background-image":'url('+imDefault+')'}); 
                      }else{
                        imageBox.css({"background-image":'unset'})
                      }
                      imageBox.attr({"data-status":dataStatus,"data-msg":dataMsg}).removeAttr("title").removeClass("tmp-image");
                    }
                  }
  
                  if(hasCallback) {
                      window[onmod](Object.freeze({
                      picker: inputFile.get(0), // file picker
                      mediaTag: inputFile.prop('tagName').toLowerCase(), 
                      viewBox: (imageBox?imageBox.get(0) : null), // box for image display
                      strict: dataStrict,
                      input: {
                        value : inputFile.val(), // input value
                        name: fileName, 
                        ext: fileExt,
                        maxSize: dataSize,
                        size: fileSize,
                        sizeString: sizeString,  
                        type: fileType,
                        class: 'image',
                        msg: dataMsg,
                        success: dataStatus === 'success', 
                      },
                      status: dataStatus, 
                    }));
                  }
    
                }
    
                if(isvidField){
    
                  //set default variables
                  let videoBox, vidLen, loadVideo, loadVideoStrict, loadSizeStrict, loadVideoStrictSize;
    
                  loadVideo = (dataLoad == 'video' || dataLoad == 'vid')? true : false;  //simple change 
                  loadVideoStrict = (dataLoad == 'video-strict' || dataLoad == 'vid-strict')? true : false;  //change only valid video    
                  loadSizeStrict = (dataLoad == 'vidsize-strict')? true : false;  //change only valid size      
                  loadVideoStrictSize = (dataLoad == 'vid-strict-sz')? true : false;  //change only valid size and video  
                  
                  //restrict load option
                  if(loadVideo){ makeswitch = true; } //simple load
                  if(loadVideoStrict  && fileTypes.includes(fileExt)){ makeswitch = true; } //restrict media loading
                  if(loadSizeStrict  && !isLarge){ makeswitch = true; } //restrict size loading
                  if(loadVideoStrictSize  && fileTypes.includes(fileExt) && !isLarge){ makeswitch = true; } //restrict media and size loading   
    
                  //select video area
                  if(parentCover.find("[data-vsrc]").length > 0){
                    videoBox  = parentCover.find("[data-vsrc]");
                    vidLen    = videoBox.length;
                  }else if(parentCover.find("[vsrc]").length > 0){
                    videoBox  = parentCover.find("[vsrc]");
                    vidLen    = videoBox.length;
                  }

                  let vidTag, fileUrl, realSource, autoplay, loadIcon, poster, video, isLoad = false;
  
                  // autoplay = inputFile.data('autoplay');
                  vidTag   = videoBox.prop('tagName').toLowerCase();
                  if(vidTag === 'div' && videoBox.find('iframe').length === 1){
                    videoBox = videoBox.find('iframe');
                    vidTag = 'iframe';
                  }
                  loadIcon = videoBox.data('loadicon') || false; // loader icon
                  poster   = videoBox.attr('data-poster') || videoBox.attr('poster');   
                  
                  if(vidLen > 0){
    
                    //reset declared attributes
                    parentCover.removeAttr('data-success');
                    videoBox.attr({'type':'','title':''}).removeAttr('data-status data-msg poster').removeClass("tmp-video");
    
                    if((makeswitch == true) && (videoBox != null)){
    
                      //change the background loading icon'

                      if(loadIcon){
                        videoBox.attr({'data-poster':poster}).css({'background-image':'url('+loadIcon+')'});
                      }
    
                      if(videoBox.find('source').length > 0){ 
                          videoBox.find('source').remove(); //remove old source
                          videoBox.get(0).load();
                      } 
    
                      var reader = new FileReader();
                      
                      reader.onload=function(event){
    
                        if(['iframe','embed','object','video'].includes(vidTag)){

                          if(vidTag == 'iframe' || vidTag == 'embed'){
                            videoBox.attr({'src':reader.result}).attr({'title':fileName}).addClass("tmp-video");
                          }
      
                          if(vidTag == 'object'){
                            videoBox.attr({'data':reader.result,'type':fileType,'title':fileName}).addClass("tmp-video");
                          }
      
                          if(vidTag == 'video'){
      
                            if(videoBox.find('source').length > 0){ 
                              videoBox.find('source').remove(); //remove old source
                              videoBox.removeAttr('src');
                            } 
      
                            fileUrl = URL.createObjectURL(file); //blob
                            realSource = new SSDom('<source>'); //new source
                            realSource.attr({'src': fileUrl}); 
      
                            //change the background back
                            videoBox.attr({'poster':''});
                            // videoBox.onload = () => URL.revokeObjectURL(fileUrl);
      
                          }
                          
                          setTimeout(function() {
                            let video, checkVideo;
                            
                            if(video && vidTag === 'video'){
                              videoBox.append(realSource);
                              video = videoBox.get(0); 
                              queueMicrotask(() => { if(typeof video.load === 'function') video.load(); });
                            }else{
                              video = videoBox.get(0); 
                            }

                            checkVideo = function(elapsed){
                                
                                //URL.revokeObjectURL(fileUrl)
                                (loadIcon)? videoBox.css({'background-image':''}) : '';
    
                                let mediaCheck = false;
                                if(vidTag === 'video'){
                                  let duration = Math.round(video.duration);
                                  let buffered = Math.round(video.buffered.end(0));
                                  let percent  = Math.round(100 * buffered / duration);
                              
                                  if(buffered >= duration || percent == 100){
                                    parentCover.attr({'data-success':''});
                                    videoBox.attr({"title":fileName,"data-status":dataStatus,"data-msg":dataMsg,'type':fileType}).addClass("tmp-video");
                                    if(videoBox.hasAttr('autoplay')){ video.play(); }
                                    mediaCheck = true;
                                  }
                                }else{
                                  mediaCheck = elapsed;
                                }
                                if(elapsed) dataMsg = 'slow loading detected';
                                if(hasCallback) { 
                                  window[onmod](Object.freeze({
                                    picker: inputFile.get(0), // file picker
                                    mediaTag: vidTag, 
                                    viewBox: (videoBox?videoBox.get(0) : null), // box for video display
                                    strict: dataStrict,
                                    input: {
                                      value : inputFile.val(), // input value
                                      name: fileName, 
                                      ext: fileExt,
                                      maxSize: dataSize,
                                      media: video,
                                      mediaCheck: mediaCheck, 
                                      size: fileSize,
                                      sizeString: sizeString,  
                                      type: fileType,
                                      class: 'video',
                                      msg: dataMsg,
                                      success: dataStatus === 'success', 
                                    },
                                    status: dataStatus, 
                                  }));
                                }
                            }
                            
                            videoBox.timedLoad(1500, function(elapsed){
                               checkVideo(elapsed);
                            })

                          }, 3000);
                        } else {
                          
                          if(hasCallback) { 
                            window[onmod](Object.freeze({
                              picker: inputFile.get(0), // file picker
                              mediaTag: vidTag, 
                              viewBox: (videoBox?videoBox.get(0) : null), // box for video display
                              strict: dataStrict,
                              input: {
                                value : inputFile.val(), // input value
                                name: fileName, 
                                ext: fileExt,
                                maxSize: dataSize,
                                media: video,
                                mediaCheck: false, 
                                size: fileSize,
                                sizeString: sizeString,  
                                type: fileType,
                                class: 'video',
                                msg: dataMsg,
                                success: dataStatus === 'success', 
                              },
                              status: dataStatus, 
                            }));
                          }

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
  
                  } else{

                    if(hasCallback) {
                      window[onmod](Object.freeze({
                        picker: inputFile.get(0), // file picker
                        mediaTag: vidTag, 
                        viewBox: (videoBox?videoBox.get(0) : null), // box for video display
                        strict: dataStrict,
                        input: {
                          value : inputFile.val(), // input value
                          name: fileName, 
                          ext: fileExt,
                          maxSize: dataSize,
                          size: fileSize,
                          sizeString: sizeString,  
                          type: fileType,
                          class: 'video',
                          msg: dataMsg,
                          success: dataStatus === 'success', 
                        },
                        status: dataStatus, 
                      }));
                    }
                  }
  
                }
    
              }
            }, 10);
         
        }else{
          if(hasCallback) {
            window[onmod](Object.freeze({
              picker: inputFile.get(0), // file picker
              mediaTag: inputFile.prop('tagName').toLowerCase(), 
              viewBox: null,
              strict: dataStrict,
              input: {
                value : inputFile.val(), // input value
                name: undefined, 
                ext: undefined,
                maxSize: dataSize,
                size: undefined, 
                sizeString: '', 
                type: undefined,
                class: 'file',
                msg: 'file selected is unreadable',
                success: false, 
              },
              status: 'failed', 
            }));
          }
        }

      });
      
    }
  }

}

export default SPAuto(LoadFile);
