import { SPAuto } from "./autoload/SPAuto.js";
import SSDom, { miDom } from "./autoload/SSDom.js";

class Forms {

    static fmState = new WeakMap();
    static queued = [];
    static #iqueued = new WeakMap();

    /**
     * Ensure a manual form fill
     */
    static manualize (selector) {
        let forms;

        if((typeof selector === 'object') && (typeof selector.targets === 'string')){
            document.querySelectorAll(selector.targets).forEach(field => {
                const type = field.type?.toLowerCase();
                if (['button', 'submit', 'reset', 'hidden'].includes(type)) return;

                field.value = '';
                field.defaultValue = '';

                ['paste', 'cut', 'drop'].forEach(event => {
                    field.addEventListener(event, e => e.preventDefault());
                });

                field.addEventListener('input', () => {
                    field.dataset.touched = "true";
                });
            });
        } else {

            if(!selector){
                forms = miDom('form[autocomplete="off"]').selections();
            }else{
                forms = miDom(selector).selections();
            }
    
            forms.forEach(form => {
    
                let fields, dataManualize = form.getAttribute('data-manualize');

                if(dataManualize && (dataManualize !== 'true')){
                    // data-manualize pointing to a value
                    let manualized = form.getAttribute('data-manualize');
                    manualized = manualized.trim();
                    if(manualized === '') manualized = 'manualized';
                    fields = form.querySelectorAll(`[${manualized}]`);
                }else{
                    fields = form.querySelectorAll('input, select, textarea');
                }
    
                fields.forEach(field => {
                    const type = field.type?.toLowerCase();
                    if (['button', 'submit', 'reset', 'hidden'].includes(type)) return;
    
                    field.value = '';
                    field.defaultValue = '';
    
                    ['paste', 'cut', 'drop'].forEach(event => {
                        field.addEventListener(event, e => e.preventDefault());
                    });
                });
    
            });

        }
    }

    static queue(callback, time = 0, name = null, form) {

        if(callback === false){
            name = (isNaN(time) && (name == null))? time : name;

            if(name){
                let pointer = this.#iqueued.get(form);
                if(pointer !== undefined){
                    if(pointer[name] !== undefined){
                        clearTimeout(pointer[name])
                        delete pointer[name]; // delete pointer through manual calls
                        this.#iqueued.set(form, pointer); // update pointer
                    }
                }
            }else{
                for (let i = this.queued.length-1; i>=0; i--){
                    clearTimeout(this.queued[i]);
                    this.queued.splice(i, 1);
                }
            }
        }else if(typeof callback === 'function'){
            if(name !== null){
                let pointer = this.#iqueued.get(form) || {};
                let iqueued = this.#iqueued;
                pointer[name] = setTimeout(() => {
                    callback();
                    delete pointer[name]; // delete pointer after timeout execution
                    iqueued.set(form, pointer);
                }, time);
                this.#iqueued.set(form, pointer);
            }else{
                let tthis = this, length = tthis.queued.length;
                this.queued.push(setTimeout(() => {
                    callback();
                    tthis.queued.splice(length, 1);
                }, time));
            }
        }
    }

    static validate(form, responder) {

        const inputsQuery = '::input:not([data-skip])';
        let fmState = this.fmState;

        if(responder && typeof responder !== 'function'){
            throw new Error('argument 2 supplied on forms.validate() must be a function');
        }

        function respond(field, message, init) {
            let responsePane, responseField;
            responsePane = field.data('resp'); //selector
            responseField = field.find(responsePane); // selection
            if(responseField) {
                if(init && (responseField.attr('eager') === 'false')) return; 
                responseField.html(message); 
            }
        }

        function inputAttributes(elem) {
            elem = miDom(elem);
            // field declarations
            let isRequired = (elem.hasAttr("required")) ? true : false;
            let isSanizited = elem.data('type') === 'sanitized';
            let formField = elem.closest(form);

            // length controllers
            let dataMin = elem.data('min') || 0;
            let dataMax = elem.data('max') || Infinity;

            // type controller
            let dataType = elem.hasAttr(["type",'data-type'], (values) => values.type ?? (values['data-type']?? 'text'))
            let dataBridge = elem.data('bridge') || "  ";
            let bridgeSect = dataBridge.split('/'); // false
            if(bridgeSect.length === 2) {
                dataBridge = bridgeSect[0];
                bridgeSect = bridgeSect[1];
            }else{
                bridgeSect = false;
            }
            let inputClass = elem.data('type') || elem.attr('type') || 'text';
            inputClass = inputClass === 'mail'? 'email' : inputClass;

            //  input field name : retrieved with appended suffix
            let inputName = elem.data('name') || elem.attr('name') || elem.attr('id');
            let fieldName = elem.hasAttr("name", (value) => value? value + ' field' : ''); 

            fieldName = fieldName.replace("_", " ");
            fieldName = elem.hasAttr("data-name")? elem.data('name') : fieldName;
            if(!fieldName && elem.hasAttr('id')) fieldName = elem.attr('id');

            // field settings
            let allowSpace = elem.data('space', (val) => ![false].includes(val)) //def: true
            let allowChars = elem.data('chars');

            // input data pointers
            let regexPattern = elem.data("pattern");
            
            let isNumField = elem.hasAttr(['type','data-type'], (input) => [input.type, input['data-type']].includes('number'));
            let isPassField = elem.hasAttr(['type','data-type'], (input) => [input.type, input['data-type']].includes('password'));

            let isTextField = ['text','',undefined].includes(elem.attr('type'));
            let isTextInput = inputClass === 'text';
            let isAlpha = inputClass === 'alpha';
            let isAlphaNum = inputClass === 'alpha-num';
            let isLetter = inputClass === 'letter';
            let isLetterNum = inputClass === 'letter-num';
            let isTextNum = inputClass === 'text-num';
            let isUrlField = inputClass === 'url';
            let isCreditCard = inputClass === 'credit';
            let usesProxies = elem.data('proxies') !== undefined;
            let creditPrefers = elem.data('prefers');

            if(creditPrefers && typeof window[creditPrefers] === 'function'){
                creditPrefers = window[creditPrefers];
            }

            let mailCase1 = ((elem.attr('type') === 'email') && ['email','','mail', undefined, null].includes(inputClass)); // type=email, data-type=[email|mail|null|undefined,''] 
            let mailCase2 = (elem.attr('type') === 'text' && ['email','mail'].includes(inputClass)); // type=text, data-type=email
            let mailCase3 = (['', null,undefined].includes(elem.attr('type')) && ['email','mail'].includes(inputClass)); // type=[''|undefined], data-type=email
            
            let isMailField = (mailCase1 || mailCase2 || mailCase3);
            let isTextArea = elem.prop('tagName') === 'TEXTAREA' || (inputClass === 'textarea');
            let isStrict = (typeof elem.data("strict") !== 'undefined' && elem.data("strict") !== false);

            let passFields = {}, passField1, passField2, passFieldCount;

            if ((passFieldCount = formField.find("input[data-type='password'][data-check]").length) > 0) {
                passField1 = (passFieldCount > 0) ? formField.find("input[data-type='password'][data-check]").eq(0) : false;
                passField2 = (passFieldCount > 1) ? formField.find("input[data-type='password'][data-check]").eq(1) : false;
            } else {
                passFieldCount = formField.find("input[data-type='password'][data-check]").length;
                passField1 = (passFieldCount > 0) ? formField.find("input[type='password'][data-check]").eq(0) : false;
                passField2 = (passFieldCount > 1) ? formField.find("input[type='password'][data-check]").eq(1) : false;
            }

            if(passField1) passFields[0] = passField1; 
            if(passField2) passFields[1] = passField2; 


            //input color object
            let objectFiller = {};
            objectFiller = fillBucket(formField, elem);
            //split the color fill
            let dataValue = (elem.val() != null) ? elem.val().trim() : null;
            let dataLength = (dataValue == null) ? 0 : dataValue.length;

            // if (isTextArea && (specialChars == undefined)) {
            //     //allowChars = "all";
            // }
            let dataIndex = elem.index(elem) + 1;
            objectFiller.formField = formField.get(0),
            objectFiller.input = elem.get(0);
            objectFiller.minVal = dataMin;
            objectFiller.maxVal = dataMax;

            let inputObject = {
                dataInput: elem,
                dataIndex: dataIndex,
                dataType: dataType,
                dataValue: dataValue,
                dataLength: dataLength,
                dataMin: dataMin,
                dataMax: dataMax,
                dataBridge: dataBridge,
                bridgeSect: bridgeSect,
                fieldName: fieldName,
                inputName: inputName,
                isStrict: isStrict,
                isTextField: isTextField,
                isTextInput: isTextInput,
                isTextNum: isTextNum,
                isAlpha: isAlpha,
                isAlphaNum: isAlphaNum,
                isLetter: isLetter,
                isLetterNum: isLetterNum,
                isNumField: isNumField,
                isPassField: isPassField,
                isUrlField: isUrlField,
                isCreditCard: isCreditCard,
                isMailField: isMailField,
                isTextArea: isTextArea,
                isRequired: isRequired,
                isSanizited: isSanizited,
                inputType : dataType,
                inputClass : inputClass,
                smartBtn: formField.find('::button[data-submit]').length > 0,
                allowSpace: allowSpace,
                allowChars: allowChars,
                passFields: passFields,
                regexPattern: regexPattern,
                usesProxies: usesProxies,
                creditPrefers: creditPrefers,
                filler: objectFiller,
            }

            return inputObject;
        }

        function fillBucket(formField, elem) {
            let objectFiller = {};

            //colors controllers
            let colorSets = ['fill', 'text', 'shadow', 'line', 'outline'];

            let colorSet = elem.data("fillset") || formField.data('fillset'); 
            let colorFill = elem.data("fill", undefined, { original: true }) || formField.data('fill', undefined, { original: true }) || '';
            let fmColors, colors;

            objectFiller.type = colorSet;

            if(colorFill.startsWith('::')){
                colorFill = colorFill.substr(2);
                colors = colorFill.split(" ");
                colorFill = window[colorFill] ?? null;
                if(colors.length > 1) {
                    console.warn('unsupported "data-fill" format');
                    objectFiller.colors = colors;
                    return objectFiller; // restrict to one value
                }
                objectFiller.colorFill = colorFill;
                return objectFiller;
            }

            if (colorSet != false) {
                if (colorFill && colorSet) {

                    //split defined colors
                    colors = colorFill.split(" "); 
                    objectFiller.colors = colors.map(s => {
                        s = s.trim();
                        if (s === '-' || s === ':') return '';
                        if (s.startsWith(':')) return s.slice(1);
                        return s;
                    });

                    if(!colorSets.includes(colorSet)) return objectFiller;

                    // if(colors.length === 2){
                    //     fmcolors =  colors.map(color => { return color.replace(":", ""); });
                    //     if(colorFill.startsWith(':')){
                    //         objectFiller.success = (fmColors[0] == "-") ? '' : fmColors[0];
                    //         objectFiller.error = "";
                    //     }
                    // }

                    //ensure that both colors and fill type is set
                    if ((colors.length > 0) && colorSets.includes(colorSet)) {

                        objectFiller.type = colorSet;  // fill, text, shadow, line, outline

                        if (colorFill.includes(":")) {
                            //allow shorthand usage
                            fmColors = colors.map(color => { return color.replace(":", ""); })
                            
                            if (colorSet === 'fill') {
                                if ((fmColors.length === 1)) {
                                    // data-fill=":success"
                                    objectFiller.success = (fmColors[0] == "-") ? '' : fmColors[0];
                                    objectFiller.error = "";
                                } else if ((fmColors.length === 2)) {
                                    // data-fill=":error success "
                                    objectFiller.success = (fmColors[1] == "-") ? '' : fmColors[1];
                                    objectFiller.error = (fmColors[0] == "-") ? '' : fmColors[0];
                                }
                            } else {
                                return objectFiller;
                            }

                        } else if (!colorFill.includes(":") && (colorSet === "fill")) {

                            //filling fields
                            if (colors.length === 1) {
                                // fill: data-fill="success"
                                objectFiller.success = (colors[0] == "-") ? '' : colors[0];
                                objectFiller.error = '';
                            } else if (colors.length === 2) {
                                // fill: data-fill="error success"
                                objectFiller.success = (colors[1] == "-") ? '' : colors[1];
                                objectFiller.error = (colors[0] == "-") ? '' : colors[0];
                            } else if ((colors.length > 2) && (colors.length < 5)) {
                                
                                // fill: data-fill="error errorText success successText"
                                colors[3] = (typeof colors[3] !== 'undefined') ? colors[3] : '';

                                objectFiller.success = (colors[2] == "-") ? '' : colors[2];
                                objectFiller.successText = (colors[3] == "-") ? '' : colors[3];

                                objectFiller.error = (colors[0] == "-") ? '' : colors[0];
                                objectFiller.errorText = (colors[1] == "-") ? '' : colors[1];
                            }
                        } else {
                            if (colors.length === 1) {
                                // data-fill="success"
                                objectFiller.error = "";
                                objectFiller.success = colors[0];
                            }

                            if (colors.length > 1) {
                                // data-fill="error success"
                                objectFiller.error = (colors[0] == "-") ? '' : colors[0];
                                objectFiller.success = (colors[1] == "-") ? '' : colors[1];
                            }

                            if (colors.length === 3) {
                                objectFiller.shadow = +colors[2];
                            }
                        }

                    }
                }
            }
            return objectFiller;
        }

        function testForm(form){
            let expressor, responder, autoResponse = true, finalExpression = true;
            if((expressor = form.field.data('express'))){
                if(expressor.substr(0, 1) === '@'){
                    autoResponse = false;
                    expressor = expressor.substr(1);
                }
                if(typeof window[expressor] !== 'undefined'){ 
                    responder = window[expressor];
                }else{
                    finalExpression = false;
                }
            }
            let validForm = {}, expression, anchors, inputFields = form.inputs.elements;
            let inputIndex = 0; let tested = false; let valid = false, stateAnchors = {};

            form.inputs.each(input => {
                if(input.hasAttr('data-pattern')) {
                    input.attr('pattern', input.data('pattern'));
                    input.removeAttr('data-pattern')
                }
            })

            // validate the current input
            if(form.input !== undefined && form.input.value.length > 0){
                tested = true;
                anchors = inputAttributes(form.input, form.field);
                
                anchors.formField = form.field;
                anchors.inputs = form.inputs;
                anchors.input = form.input;
                anchors.data = form.elem;

                stateAnchors.validForm = validForm = basicValidator(anchors);
                stateAnchors.anchors = anchors;

                expression = false;
                valid = validForm.valid;

                if(autoResponse){
                    (valid) ? respond(form.field, '', anchors.init) : respond(form.field, validForm.msg || '', anchors.init);
                }
                
                if(!(fmState.get(form.field.get(0)) && anchors.isStrict) || (fmState.get(form.field.get(0)) === undefined)){
                    activeButton(form.field, anchors.smartBtn? false : true); // default disable/enable button
                }

                expression = ((valid == false) || anchors.dataInput.hasAttr('data-express')) && (typeof responder === 'function');

                if((!validForm.valid && form.elem.data && validForm.isStrict)||(validForm.invalidChar && form.elem.data && validForm.isStrict)){ 
                    form.input.value = form.input.value.substr(0, form.input.value.length - form.elem.data.length);
                }

                if(expression){
                    
                    let resPane = form.field.data('resp');
                    resPane = resPane? form.field.find(resPane).get() : undefined;

                    responder({
                        form: form.field.get(),
                        msg: validForm.msg,
                        init: anchors.init,
                        input: anchors.input,
                        inputs: anchors.inputs.selections() ,
                        inputID: validForm.inputID,
                        inputType: validForm.inputType,
                        inputClass: validForm.inputClass,
                        inputName: anchors.inputName,
                        inState: true,
                        current: true,
                        required: validForm.type === 'required',
                        responsePane: resPane,
                        valid: valid,
                        invalidChar: validForm.invalidChar,
                        queue: (callback, time = 0, name) => {
                            Forms.queue(callback, time, name, form.field.get(0))
                        },
                        respond: (msg) => respond(form.field, msg, anchors.init),
                        submitBtn: (enable) => activeButton(anchors.formField, enable)
                    });
                }

                if(!valid) return false; // return if current field is not valid
            }

            for(let inputField of inputFields){
                          
                if(tested && (inputField === form.input)) {
                    // ignore already tested field
                    inputIndex = inputIndex + 1;
                    continue;
                }
                anchors = inputAttributes(inputField);
              
                anchors.formField = form.field;
                anchors.inputs = form.inputs;
                anchors.input = inputField;
                anchors.init = form.input? false : true;
                anchors.data = form.elem;
                
                validForm = basicValidator(anchors);
                valid = validForm.valid;
                expression = false;

                if(!stateAnchors.validForm){
                    stateAnchors.validForm = validForm;
                    stateAnchors.anchors = anchors;
                }

                if(autoResponse){
                    (valid) ? respond(form.field, '', anchors.init) : respond(form.field, validForm.msg || '', anchors.init);
                }

                if(anchors.smartBtn && !valid) activeButton(form.field, false);

                expression = (!valid || anchors.dataInput.hasAttr('data-express')) && responder;
                let resPane = form.field.data('resp');
                resPane = resPane? form.field.find(resPane).get() : undefined;

                if(expression){
                    responder({
                        form: form.field.get(),
                        msg: validForm.msg,
                        init: anchors.init,
                        input: anchors.input,
                        inputs: anchors.inputs.selections(),
                        inputID: validForm.inputID,
                        inputType: validForm.inputType,
                        inputClass: validForm.inputClass,
                        inputName: anchors.inputName,
                        current: false,
                        inState: true,
                        isSpace: validForm.isSpace,
                        queue: (callback, time = 0, name) => {
                            Forms.queue(callback, time, name, form.field.get(0))
                        },
                        required: validForm.type === 'required',
                        responsePane: resPane,
                        valid: valid,
                        invalidChar: validForm.invalidChar,
                        respond: (msg) => respond(form.field, msg, anchors.init),
                        submitBtn: (enable) => activeButton(formField, enable)
                    });
                }

                if(!valid) break;

                inputIndex = inputIndex + 1;
            }

            if(valid){
                 fmState.set(form.field.get(0), valid);
                 activeButton(form.field, true);
                 let resPane = form.field.data('resp');
                 resPane = resPane? form.field.find(resPane).get() : undefined;
                 
                 if(finalExpression && responder){
                     responder({
                         form: form.field.get(),
                         init: anchors.init,
                         input: stateAnchors.anchors.input,
                         inputName: stateAnchors.anchors.inputName,
                         inputs: anchors.inputs.selections() ,
                         inState: false,
                         final: true,
                         valid: valid,
                         invalidChar: validForm.invalidChar,
                         responsePane: resPane,
                         queue: (callback, time = 0, name = null) => {
                            Forms.queue(callback, time, name, form.field.get(0))
                         },
                         respond: (msg) => respond(form.field, msg, anchors.init),
                         submitBtn: (enable) => activeButton(form.field, enable)
                     });
                 }
            }

        }

        function lockForm(e){
            e.preventDefault();
        }

        function activeButton(form, activate){
            let button = form.find('::button[data-submit]'); // find buttons like: [type=button|submit], button
            if(activate){
                form.off('submit', lockForm)
                button.removeAttr("disabled");
            }else{
                form.on('submit', lockForm)
                button.attr("disabled", "disabled");
            }
        }


        function isValidHttpUrl(string) {
            let url;

            try {
                url = new URL(string);
            } catch (_) {
                return false;
            }

            let protocols = ["http:", "https:"];

            return protocols.includes(url.protocol) ? true : false;

        }

        function inputFiller(input, action, fill) {

            if (fill === false) { return; }
            let filler = fill;
            if(fill.colorFill){
                fill.colorFill({
                    form: fill.formField,
                    input: fill.input,
                    minVal: fill.minVal, 
                    maxVal: fill.maxVal,
                    valid: action, 
                    fill: fill.type, // colorSet type
                })
                return;
            }

            setTimeout(() => {

                if(input.hasAttr('data-ico')){
                    input = input.parent().find('input');
                }
    
                if (action === "reset") {
                    if (filler.success || filler.error) {
                        input.css({ 'color': '' });
                        input.css({ 'background-color': '' });
                    }
                    if(input.get(0).style.boxShadow) input.css({ 'box-shadow': '' });
                    if(input.get(0).style.border) input.css({ 'border': '' });
                    if(input.get(0).style.outlineOffset) input.css({ 'outline-offset': '' });
                    return;
                }
    
                let key1, key2, thickness, ooffset, colors = filler.colors, fillColor, textColor, shadow;
    
                key1 = (action === true) ? 'success' : 'error';
                key2 = (action === true) ? 'successText' : 'errorText';
    
                if(filler.type === 'outline' && colors.length === 4){
                    thickness = colors[2];
                    ooffset = colors[3]; 
                }
    
                if (filler.shadow) { shadow = filler.shadow }
                if ((key1 === 'success') || (key1 === 'error')) {
                    fillColor = filler[key1]; // filler.(success|error)
                    textColor = filler[key2]; // filler.(successText|errorText)
             
                    if (filler.type === 'fill') {
                        input.css({ 'background-color': fillColor });
                        if (filler.successText || filler.errorText) {
                            input.css({ 'color': textColor });
                        }
                    } else if (filler.type === 'text') {
                        input.css({ "color": fillColor });
                        if (shadow) {
                            if (fillColor == '') {
                                input.css({ 'box-shadow': `` });
                            } else {
                                input.css({ 'box-shadow': `0 0 0 ${shadow}px ${fillColor} inset` });
                            }
                        }
                    } else if (filler.type === 'line') {
                        input.css({ 'border': `solid ${shadow}px ${fillColor}` });
                    }  else if (filler.type === 'outline') {
                        input.css({ 'outline': `solid ${thickness}px ${fillColor}` });
                        if(ooffset) input.css({ 'outline-offset': `${ooffset}px` });
                    }else if (filler.type === 'shadow') {
                        if ((key1 != "") && (fillColor != "")) {
                            input.css({ 'box-shadow': `0 0 0 ${shadow}px ${fillColor} inset` });
                        } else {
                            input.css({ 'box-shadow': '' });
                        }
                    }
                }

            })

        }

        function basicValidator(anchors) {
            let input = anchors.dataInput;
            let currentKey = anchors.data;
            let isRequired = anchors.isRequired;
            let isTextField = anchors.isTextField;
            // let isTextInput = anchors.isTextInput; // behaves  like normal text field
            let isSanitized = anchors.isSanitized;
            let isTextNum = anchors.isTextNum;
            let isAlpha = anchors.isAlpha;
            let isAlphaNum = anchors.isAlphaNum;
            let isLetter = anchors.isLetter;
            let isLetterNum = anchors.isLetterNum;
            let isUrlField = anchors.isUrlField;
            let isCreditCard = anchors.isCreditCard;
            let isMailField = anchors.isMailField;
            let isPassField = anchors.isPassField;
            let isNumField = anchors.isNumField;
            let isStrict = anchors.isStrict;
            let usesProxies = anchors.usesProxies;
            let dataBridge = anchors.dataBridge;
            let bridgeSect = anchors.bridgeSect;
            let dataIndex = anchors.dataIndex;
            let dataValue = anchors.dataValue;
            let dataLength = anchors.dataLength;
            let dataMin = anchors.dataMin;
            let dataMax = anchors.dataMax;
            let inputID = anchors.inputs.index(anchors.input) + 1;
            let inputType = anchors.inputType;
            let inputClass = anchors.inputClass;
            let fieldName = anchors.fieldName || 'field ' + (anchors.inputs.index(anchors.input) + 1);
            let fieldName1 = fieldName, fieldName2 = fieldName, fieldMsg1;
            let fill = anchors.filler;
            if(fieldName){
                fieldName1 = ' '+fieldName;
                fieldName2 = fieldName + ' ';
                fieldMsg1 = ` in ${fieldName}`;;
            }else{
                fieldMsg1 = ' for ' + fieldName;
                //fieldMsg2 = ' for ' + fieldName;
            }
            let responseField = anchors.responseBox;
            let button = anchors.submitBtn;
            let passFields = anchors.passFields;
            let passFieldCount = Object.keys(passFields).length;
            let passField1 = passFields[0];
            let passField2 = passFields[1];
            //special validation
            let allowSpace = anchors.allowSpace;
            let allowChars = anchors.allowChars;
            let regexPattern = anchors.regexPattern;
            let $pattern;
            
            //reformat allowChars email to "mail"
            // allowChars = (allowChars === "email") ? "mail" : allowChars;

            let testMail = (isMailField && allowChars == 'mail') ? true : false;
            
            let invalidError = {type: 'invalid', valid: false, inputID: inputID, inputType : inputType, inputClass: inputClass, isStrict: isStrict};

            //* Initial test to determine if field is required (first order)
            if(isRequired){
                if(dataLength < 1){
                    return {...invalidError, ...{type: 'required', msg: fieldName2 + 'required'} }
                }
            }

            // enforce data-regex pattern immediate after required fields. (second order)
            if(regexPattern){
                let pattern = "^" + regexPattern + "$";
                let regex = new RegExp(pattern);

                if (regex.test(dataValue) === false) {
                    
                    if(anchors.init) {
                        input.val('');
                    }else{
                        if(!isStrict)inputFiller(input, false, fill);
                        return {...invalidError,...{msg: 'invalid format not supported ' + fieldMsg1}}
                    }
                }
            }

            // enforce data-chars for characters range. (third order)
            if(allowChars) {
                $pattern = allowSpace? "^[" + allowChars + " ]*$" :  "^[" + allowChars + "]*$";
                let regex = new RegExp($pattern, "i");

                if (regex.test(dataValue) === false) {
                    if(anchors.init) input.val('');
                    if(!isStrict) inputFiller(input, false, fill);
                    return {...invalidError,...{msg: 'invalid characters not supported ' + fieldMsg1}}
                }
            }
            if (isCreditCard) {

                if(!anchors.init) {
    
                    let value = dataValue.replace(/\D/g, '');
                    if(bridgeSect && !usesProxies){
                        if(value.length <= (4 * bridgeSect)){
                            input.val(value.replace(/(\d{4})(?=\d)/g, `$1${dataBridge}`));
                        }else if(!anchors.init){
                            value = value.substr(0, value.length - currentKey.data.length)
                            input.val(value.replace(/(\d{4})(?=\d)/g, `$1${dataBridge}`));
                        }
                    }else{
                        input.val(value.replace(/(\d{4})(?=\d)/g, `$1${dataBridge}`));
                    }
    
                    if (!/^[0-9]+$/.test(value)) {
                        if(anchors.init) { 
                            input.val('');
                        }else{
                            inputFiller(input, false, fill);
                            return {...invalidError,...{msg: fieldName2 + 'card invalid'}};
                        }
                    }
    
                    // validCards -> ['america-express', 'discover', 'mastercard', 'visa', 'verve'];
    
                    if ((value.length > 0) && usesProxies) {
                        if(!anchors.init){
                            if(!Forms.CreditCard.suppressed(input.get())){
                                Forms.CreditCard.buildProxyFields(input, value);
                            }
                        }
                    }
    
                    let cardType = Forms.CreditCard.detectCreditType(dataValue, anchors);
                    if(cardType) {
                        cardType = cardType.toLowerCase()
                        cardType = cardType.replace(' ','-');
                        input.attr({ 'data-card': cardType });
                    }else{
                        inputFiller(input, false, fill);
                        input.removeAttr('data-card');
                        if(anchors.init) input.val('');
                        return {...invalidError,...{msg: fieldName2 + 'card unknown'}};
                    }
    
                    // Test card using Luhn Algorithm
    
                    if(!Forms.CreditCard.luhnCheck(value)){
                        if(!anchors.init) {
                            inputFiller(input, false, fill);
                            return {...invalidError,...{msg: fieldName2 + 'card denied'}};
                        }
                    }
    
                    let dataSupportValues = input.attr('data-support');
                    if (dataSupportValues) {
    
                        if (dataSupport.substr(0, 1) === "-") {
                            let dataReject = dataSupport.substr(0, 1); //dataSupport negation
                            let dataSupport = dataReject.split(" ");
    
                            if (dataSupport.includes(cardType)) {
                                if(!anchors.init) {
                                    inputFiller(input, false, fill);
                                    return {...invalidError,...{msg: fieldName2 + 'card denied'}};
                                }
                            }
                        } else {
                            let dataSupport = dataSupportValues.split(" ");
                            if (!dataSupport.includes(dataCard)) {
                                if(!anchors.init) {
                                    inputFiller(input, false, fill);
                                    return {...invalidError,...{msg: fieldName2 + 'card denied'}};
                                }
                            }
                        }
                    }

                }else{
                    input.val('') // remove cached inputs
                }

            }

            // // enforce ((data-type)=text-num) fields to accept only alphabets and numbers.
            // if (isTextNum) {
            //     if (/^[^A-Za-z0-9\s]+$/.test(dataValue)) {
            //         inputFiller(input, false, fill);
            //         return {...invalidError,...{valid: false, msg: fieldName2 + 'can only contain alphabets and numbers'}}
            //     }
            // }

            // enforce ((data-type)=letter) fields to accept only alphabets and numbers.
            if (isLetter) {
                $pattern = allowSpace? /[^\p{L} ]+/u : /[^\p{L}]+/u ;
                if ($pattern.test(dataValue)) {
                    if(anchors.init) {
                        input.val('');
                    }else{
                        inputFiller(input, false, fill);
                        return {...invalidError,...{msg: fieldName2 + 'can only contain letters'}}
                    }
                }
            }

            // enforce ((data-type)=letter-num) fields to accept only alphabets and numbers.
            if (isLetterNum) {
                $pattern = allowSpace ? /[^\p{L}\p{N} ]+/u : /[^\p{L}\p{N}]+/u  ;
                if ($pattern.test(dataValue)) {
                    if(anchors.init) {
                        input.val('');
                    }else{
                        inputFiller(input, false, fill);
                        return {...invalidError,...{msg: fieldName2 + 'can only contain letters and numbers'}}
                    }
                }
            }
            
            // // enforce ((data-type)=text) fields to accept every other text except digits.
            // if ((dataLength > 0) && isTextInput && (/\d/.test(dataValue))) {
            //     inputFiller(input, false, fill);
            //     return {...invalidError,...{msg: fieldName + ' cannot contain digits'}}
            // }

            // enforce ((data-type)=alpha) fields to accept only alphabets
            if ((dataLength > 0) && isAlpha) {
                $pattern = allowSpace? /[^A-Za-z ]+/ :  /[^A-Za-z]+/;
                if($pattern.test(dataValue)){
                    if(anchors.init) {
                        input.val('');
                    }else{
                        inputFiller(input, false, fill);
                        return {...invalidError,...{msg: fieldName + ' can only contain alphabets'}}
                    }
                }
            }

            // enforce ((data-type)=alpha-num) fields to accept only alphabets and numbers
            if ((dataLength > 0) && (isAlphaNum || isTextNum)) {
                $pattern = allowSpace? /[^A-Za-z0-9 ]+/ :  /[^A-Za-z0-9]+/;
                if($pattern.test(dataValue)){
                    if(anchors.init) {
                        input.val('');
                    }else{
                        inputFiller(input, false, fill);
                        return {...invalidError,...{msg: fieldName + ' can only contain alpha numeric'}}
                    }
                }
            }
            
            // enforce ((data-type)=sanitized) fields to accept only alphabets
            if (isSanitized) {
                let $pattern = allowSpace? /[`!@#$%^&*()+\-=\[\]{};':"\\|,.<>\/?~]/ : /[ `!@#$%^&*()+\-=\[\]{};':"\\|,.<>\/?~]/;
                if($pattern.test(dataValue)){
                    if(anchors.init) {
                        input.val('');
                    }else{
                        inputFiller(input, false, fill);
                        return {...invalidError,...{msg: fieldName + ' contains invalid special characters'}}
                    }
                }
            }

            // enforce ((type,data-type)=number) fields to be numerical
            if ((dataLength > 0) && isNumField) {
                if(allowSpace) dataValue = dataValue.replace(/\s/g, '');
                if(isNaN(dataValue)){
                    if(anchors.init) {
                        input.val('');
                    }else{
                        inputFiller(input, false, fill);
                        return {...invalidError,...{msg: fieldName + ' must be numerical number'}}
                    }
                }
            }

            // // strict number field ((type,data-type)=number) && data-strict
            // if ((dataLength > 0) && isNumField) {
            //     inputFiller(input, false, fill);
            //     return {...invalidError,...{msg: fieldName + ' must be valid'}}
            // }

            // Test for minimum(data-min) and maximum(data-max) values specified ...........................
            if (((dataLength < dataMin) || (dataLength > dataMax)) && (dataLength != 0)) {
                let msg;
                if (dataLength < dataMin) {
                    inputFiller(input, false, fill);
                    msg = {...invalidError,...{msg: fieldName + ' is too short'}}
                }

                if (dataLength > dataMax) {
                    inputFiller(input, false, fill);
                    msg = {...invalidError,...{msg: fieldName2 + 'is too long'}}
                    // responseField.html(" <span class='form-validator-message'> " + fieldName + " is too long  </span>");
                }
                return msg;
            }
            
            // Test for space if defined....................................................................
            if ((dataLength > 0) && !testMail) {

                if (allowSpace === false) {
                    if (/\s/.test(dataValue)) {
                        if(anchors.init) input.val('');
                        inputFiller(input, false, fill);
                        return {...invalidError,...{msg: 'invalid space in' + fieldMsg1}}
                    }
                }

                if (allowChars === 'rex' && regexPattern != undefined) {
                    let pattern = "^[" + regexPattern + "]*$";
                    let regex = new RegExp(pattern, "i");

                    if (regex.test(dataValue) != true) {
                        if(anchors.init) input.val('');
                        inputFiller(input, false, fill);
                        return {...invalidError,...{msg: 'invalid characters in' + fieldMsg1}}
                    }
                }

            }

            // Test for data-type='url' ......................................................................
            if (isUrlField && (dataLength > 0)) {
                if (!isValidHttpUrl(dataValue)) {
                    inputFiller(input, false, fill);
                    return {...invalidError,...{msg: 'invalid value supplied for' + fieldName1}}
                }else{
                    inputFiller(input, true, fill);
                }
            }

            if ((dataLength > 0) && (isMailField)) {
                let pattern = /^(([^<>()\[\]\\.,;:\s@"]+(\.[^<>()\[\]\\.,;:\s@"]+)*)|(".+"))@((\[[0-9]{1,3}\.[0-9]{1,3}\.[0-9]{1,3}\.[0-9]{1,3}\])|(([a-zA-Z\-0-9]+\.)+[a-zA-Z]{2,}))$/;
                if (pattern.test(String(dataValue).toLowerCase()) == false) {
                    inputFiller(input, false, fill);
                    return {...invalidError,...{msg: 'invalid' + fieldName1}}
                }else{
                    inputFiller(input, true, fill);
                }
            }
    
            if (isPassField) {

                // match pass fields
                if (passFieldCount > 1) {

                    let pass1 = passField1.val();
                    let pass2 = passField2.val(); 
                    if ((pass1 === pass2) && !([false,'undefined'].includes(pass1))) {
                        inputFiller(input, true, fill); // password matched
                    } else {
                        if (pass1 !== pass2) {
                            if (pass1.length < 1) {
                                inputFiller(passField1, 'reset', fill);
                            } else {
                                inputFiller(passField1, false, fill);
                            }

                            if (pass2.length < 1) {
                                inputFiller(passField2, 'reset', fill);
                            } else {
                                inputFiller(passField2, false, fill);
                            }
                        }
                        if(anchors.init) input.val('');
                        return {...invalidError,...{msg: 'password does not match'}};
                    }
                }
            }

            if(dataLength > 0) { 
                inputFiller(input, true, fill); 
            } else {
                // Reset colored filled
                if(fill.success) fill.success = '';
                if(fill.successText) fill.successText = '';
                inputFiller(input, true, fill); 
            }
            
            if(!allowSpace && (input.val().includes(' '))){

                if(anchors.init){
                    input.val('');
                }else{
                    if(!isStrict) {
                        inputFiller(input, false, fill);
                        return {...invalidError,...{msg: 'space character not supported' + fieldMsg1}}
                    }else{
                        return {...invalidError,...{valid: true, invalidChar: true,  msg: 'space characer not supported ' + fieldMsg1, inputID: inputID, inputType : inputType, inputClass: inputClass, isSpace: true, isStrict: isStrict}}
                    }
                }
            }

            return {valid: true, inputID: inputID, inputType : inputType, inputClass: inputClass, isStrict: isStrict};
        }

        let fms = miDom(form); // select all forms
        fms.find(inputsQuery).on('input', function(elem){
            let parentForm = miDom(elem.target).closest(form)
            testForm({field:parentForm, input:elem.target, inputs:parentForm.find(inputsQuery), elem: elem});
        })

        fms.each((fm)=>{
            if(fm.hasAttr('data-manualize')){
                Forms.manualize(fm);
            }
            fm.find(inputsQuery).each((inp) => {
                let dataHalt = inp.data('halt');
                if(dataHalt){
                    dataHalt = dataHalt.replace(/[-|]+/g, ' ');
                    dataHalt = dataHalt.split(' ');
                    dataHalt.forEach(ev => { 
                        inp.on(ev, (e) => e.preventDefault()  )
                    })
                }
            })
            testForm({
                field: fm,
                inputs: fm.find(inputsQuery)
            });
        })
        
    }

    static CreditCard = class {

        static #suppressInput = new WeakMap();
        
        static suppressInput(input, suppress = true) {
            this.#suppressInput.set(input, suppress);
        };
        
        static suppressed(input) {
            
            return this.#suppressInput.get(input);
        };

        static validators(num) {
            if (/^4\d{12}(\d{3})?$/.test(num) || /^(?:4[0-9]{12}(?:[0-9]{3})?)$/.test(num)) return 'Visa';
            if (/^5[1-5]\d{14}$/.test(num) || /^2(2[2-9]|[3-6]\d|7[01]|720)\d{12}$/.test(num) || /^(?:5[1-5][0-9]{14})$/.test(num)) return 'MasterCard';
            if (/^3[47]\d{13}$/.test(num) || /^(?:3[47][0-9]{13})$/.test(num)) return 'American Express';
            if (/^6(011\d{12}|5\d{14}|4[4-9]\d{13})$/.test(num) || /^(?:6(?:011 | 5[0-9][0-9][0-9]{16,19}))$/.test(num)) return 'Discover';
            if (/^(5060|5061|5078|5079|6500|6501|6502|6503|6504|6505)\d{10,12}$/.test(num) || /^(?:(506[0-9][0-9][0-9]{14})|(65002(7)?[0-9]{10, 11}))$/.test(num)) return 'Verve';
            if (/^3(0[0-5]|[68]\d)\d{11}$/.test(num)) return 'Diners Club';
            if (/^35(2[89]|[3-8][0-9])\d{12,15}$/.test(num)) return 'JCB';// Japan 3528–3589
            if (/^62\d{14,17}$/.test(num)) return 'UnionPay';// China 62...(<=19 digits)
            if (/^(5[06-9]|6[0-9])\d{10,17}$/.test(num) || /^(5[06789]\d{0,}|6\d{0,})\d{10,17}$/.test(num)) return 'Maestro';// Europe 50..., 56–69...
            if (/^(60|65|81|82)\d{14}$/.test(num) || /^60[0-9]{14,17}$/.test(num)) return 'RuPay';// India: 6061, 6062, 6063, 6080, 6521, 6522, etc.
            if (/^9792[0-9]{12}$/.test(num)) return 'Troy';// Turkey: 9792.
            if (/^220[0-4][0-9]{12}$/.test(num)) return 'Mir';// Russia 2200, 2201, ..., up to 2204
            if (/^5019[0-9]{12}$/.test(num)) return 'Dankort';// Denmark 5019...
            if (/^(4011(78|79)|4312(74|75)|438935|451416|457393|4576(31|32)|5041(75|76)|5090(41|42|43|44)|627780|636297|636368)[0-9]{10,12}$/.test(num)) return 'Elo';// Brazil 5019...
            if (/^1\d{14}$/.test(num)) return 'UATP';
            return null;
        }

        static detectCreditType(num, anchors) {

            if(anchors.creditPrefers){
                if(typeof anchors.creditPrefers !== 'function'){
                    console.warn('unknown preferential function '+anchors.creditPrefers+' applied on credit card.')
                }else{ 
                    return anchors.creditPrefers(num, () => Forms.CreditCard.validators(num) );
                }
            }
            return this.validators(num);
        }
        
        static luhnCheck(num){
            if((num.length < 8) || (num.length > 19)) return false;
            let sum = 0;
            for (let i = 0; i < num.length; i++) {
                let digit = parseInt(num[num.length - 1 - i]);
                if (i % 2 === 1) {
                digit *= 2;
                if (digit > 9) digit -= 9;
                }
                sum += digit;
            }
            return sum % 10 === 0;
        };

        static buildProxyFields(mainInput, seed = '') {
            const groupLength = 4;
            const maxGroups = 4;
            const maxProxies = parseInt(mainInput.data('proxies')) || false;
            let marker, useImageSeparator = mainInput.data('ico');
            useImageSeparator = [undefined, ''].includes(useImageSeparator) ? false : useImageSeparator;
            marker = useImageSeparator ? useImageSeparator.substr(0, 5) : '';
            if(['img::','uni::','bkg::'].includes(marker)) useImageSeparator = useImageSeparator.substr(5);
            mainInput = mainInput.get();
            let wrapper = mainInput.parentElement;

            // wrapper.appendChild(mainInput);
            mainInput.style.display = 'none';

            let index = 0;

            const addProxyInput = (initial = '') => {

                if ((maxProxies !== false) && (index >= maxProxies)) return null;

                if (useImageSeparator && index > 0) {
                    let divider, ico, icx;
                    if(marker === 'img::'){
                        icx = 'img'
                        divider = document.createElement('div');
                        ico = document.createElement('img');
                        ico.src = useImageSeparator;
                        divider.appendChild(ico);
                    }else if(marker === 'uni::'){
                        icx = 'uni'
                        divider = document.createElement('div');
                        divider.innerHTML = useImageSeparator;
                    }else if(marker === 'bkg::'){
                        icx = 'bkg'
                        divider = document.createElement('div');
                        ico = document.createElement('div');
                        ico.style.backgroundImage = `url(${useImageSeparator})`;
                        divider.appendChild(ico);
                    } else {
                        icx = 'icx'
                        divider = document.createElement('div');
                    }
                    divider.setAttribute('icx', icx);
                    wrapper.appendChild(divider); 
                }

                const input = document.createElement('input');
                input.type = 'text';
                input.className = 'proxy';
                input.maxLength = groupLength;
                input.value = initial;
                input.dataset.index = index++;
                input.setAttribute('proxy','false');
                wrapper.appendChild(input); // append new input
                queueMicrotask(() => input.focus()); //input.focus();

                // 👇 This handles overflow input into a new box
                input.addEventListener('beforeinput', (e) => {
                    const isDigit = /^\d$/.test(e.data);
                    if (isDigit && input.value.length === groupLength && index < maxGroups) {
                        e.preventDefault();
                        input.setAttribute('proxy','true');
                        addProxyInput(e.data); // adds, focuses and returns new input
                        setTimeout(() => Forms.CreditCard.updateMainInput(wrapper, mainInput));
                    }
                });

                // 👇 This handles backspace and removes the box if empty
                input.addEventListener('keydown', (e) => {
                    if (e.key === 'Backspace' && input.value.length === 1) {
                        // uses: (input.value.length === 1) instead of (input.value === '') for eager checking.
                        const prev = Forms.CreditCard.getPreviousInput(input);
                        if (prev) {

                            const idx = Array.from(wrapper.children).indexOf(input);
                            wrapper.removeChild(input);
                            if (useImageSeparator && ['img','icx','bkg','uni'].includes(wrapper.children[idx - 1]?.getAttribute('icx'))) {
                                wrapper.removeChild(wrapper.children[idx - 1]);
                            }

                            index--;
                            Forms.CreditCard.updateMainInput(wrapper, mainInput);
                            setTimeout(()=>prev.focus(), 100);
                        } else {
                            Forms.CreditCard.resetToMain(wrapper, mainInput);
                        }
                    }
                });

                input.addEventListener('input', () => {
                    input.value = input.value.replace(/\D/g, '');
                    Forms.CreditCard.updateMainInput(wrapper, mainInput);
                    if(input.value.length === groupLength){
                        input.setAttribute('proxy','true');
                    }else{
                        input.setAttribute('proxy','false');
                    }
                });

                return input;
            };

            const segments = seed.match(/.{1,4}/g) || [];
            segments.forEach(segment => addProxyInput(segment));

            Forms.CreditCard.updateMainInput(wrapper, mainInput);
        }

        static updateMainInput(wrapper, mainInput) {
            
            const value = Array.from(wrapper.querySelectorAll('input.proxy'))
                .map(i => i.value)
                .join('');
            if(!Forms.CreditCard.suppressed(mainInput)) Forms.CreditCard.suppressInput(mainInput, true);
            mainInput.value = value;
            mainInput.dispatchEvent(new Event('input', { bubbles: true }));

            if (value.length === 0) {
                Forms.CreditCard.resetToMain(wrapper, mainInput);
            }
        }

        static resetToMain(wrapper, mainInput) {
            wrapper.innerHTML = '';
            mainInput.value = '';
            mainInput.style.display = '';
            wrapper.appendChild(mainInput);
            this.suppressInput(mainInput, false);
            // this.#suppressInput = false;
            mainInput.focus();
        }

        static getNextInput(current) {
            let next = current.nextElementSibling;
            while (next && next.tagName !== 'INPUT') {
                next = next.nextElementSibling;
            }
            return next;
        }

        static getPreviousInput(current) {
            let prev = current.previousElementSibling;
            while (prev && prev.tagName !== 'INPUT') {
                prev = prev.previousElementSibling;
            }
            return prev;
        }

    }

}

export default SPAuto(Forms)