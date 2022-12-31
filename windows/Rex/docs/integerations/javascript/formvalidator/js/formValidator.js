(function($) {
    $.fn.validateForm = function(defOps) {
        var field = $(this);
        var responseField, submitBtn;

        //set the field object
        indefaults.field = field;

        //get the submit button
        if (field.find('[data-type="submit"]')) {
            submitBtn = field.find('[data-type="submit"]')
        } else {
            submitBtn = field.find('[type="submit"]');
        }

        //all input fields
        var allInputs = field.find(":input:not(:button):not([data-skip])");

        //set all inputs and submit buttons
        indefaults.allInputs = allInputs;
        indefaults.submitBtn = submitBtn;

        //default options
        defaultOptions = {
            responsePane: "",
            validateBtn: true,
            submitButton: submitBtn,
        }

        var mainOps = $.extend(defaultOptions, defOps);
        var validateBtn = mainOps.validateBtn;
        indefaults.validateBtn = validateBtn

        var buttonHolder = submitBtn.closest("fieldset");
        indefaults.buttonHolder = buttonHolder;
        buttonHolder.attr({ "data-active": "false" });
        (validateBtn == true) ? buttonHolder.attr({ "disabled": "disabled" }): null;
        (validateBtn == true) ? submitBtn.attr({ "disabled": "disabled" }): null;

        indefaults.responseField = responseField = field.find(mainOps.responsePane);

        if (field.find("input[data-type='password'][data-check]").length > 0) {
            passFieldCount = field.find("input[data-type='password'][data-check]").length;
            passField1 = (passFieldCount > 0) ? field.find("input[data-type='password'][data-check]").eq(0) : false;
            passField2 = (passFieldCount > 1) ? field.find("input[data-type='password'][data-check]").eq(1) : false;
        } else {
            passFieldCount = field.find("input[type='password'][data-check]").length;
            passField1 = (passFieldCount > 0) ? field.find("input[type='password'][data-check]").eq(0) : false;
            passField2 = (passFieldCount > 1) ? field.find("input[type='password'][data-check]").eq(1) : false;
        }

        field.find(":input:not(:button):not([data-skip])").each(function(index, item) {

            //applying data-init to start operation
            if ((typeof field.attr('data-init') !== 'undefined') && (typeof field.attr('data-init') !== 'false')) {
                let initFill = false;
                allInputs.each(function() {
                    if ($(this).val().length > 1) {
                        initFill = true;
                        return;
                    }
                })
                runChecker(this, initFill);
            }

            //runChecker(this);
            $(this).on("input keyup", function(e) {
                //get the input controllers

                let thisCall = $(this);
                if ($(this).attr('data-url')) {
                    //set status
                    $(this).removeAttr('data-req');
                    $(this).removeAttr('data-process');
                }

                let timeout = $(this).attr('data-wait') || field.attr('data-wait') || 0;
                timeout = +timeout;
                indefaults.current = index;
                indefaults.thisInput = {};
                setTimeout(() => {
                    var rChecker = runChecker(thisCall);
                }, timeout);

            })
        })

    }

    function runChecker(elem, fill) {

        fill = (fill !== false) ? true : false;

        var anchors = inputAttributes(elem);

        dataType = anchors.dataType;
        dataValue = anchors.dataValue;
        dataLength = anchors.dataLength;
        dataMin = anchors.dataMin;
        dataMax = anchors.dataMax;
        fieldName = anchors.fieldName;
        isNumField = anchors.isNumField;
        isPassField = anchors.isPassField;
        isTextField = anchors.isTextField;
        isUrlField = anchors.isUrlField;
        isRequired = anchors.isRequired;
        isTextArea = anchors.isTextArea;
        isStrict = anchors.isStrict;

        var buttonHolder, submitBtn;
        var field = indefaults.field;

        var responseField = indefaults.responseField;

        buttonHolder = indefaults.buttonHolder;
        validateBtn = indefaults.validateBtn;
        submitBtn = indefaults.submitBtn;

        anchors.buttonHolder = buttonHolder;
        anchors.submitBtn = submitBtn;
        anchors.responseBox = responseField;
        anchors.formField = field;
        anchors.passFieldCount = passFieldCount;
        anchors.userPassField1 = passField1;

        anchors.userPassField2 = passField2;
        anchors.validateBtn = validateBtn;
        anchors.fill = fill;

        var fieldObject = {
            field: field,
            buttonHolder: buttonHolder,
            submitBtn: submitBtn,
            responseBox: responseField,
            formField: field,
            passFieldCount: passFieldCount,
            userPassField1: passField1,
            userPassField2: passField2,
            validateBtn: validateBtn,
            allInputs: indefaults.allInputs,
            initMess: false,
            fill: fill
        }

        buttonHolder.attr({ "data-active": "false" });
        (validateBtn == true) ? buttonHolder.attr({ "disabled": "disabled" }): null;
        (validateBtn == true) ? submitBtn.attr({ "disabled": "disabled" }): null;
        anchors.initMess = fieldObject.initMess;

        //CASE 1: (empty fields)
        if (dataLength < 1) {
            if (field.is('[data-init]')) { fieldObject.initMess = true; }
            if (isRequired) {
                $(responseField).html("<span class='form-validator-message'> please fill " + fieldName + " <span class='fa fa-times-circle'></span> </span>");
                allValidator(field, fieldObject)
                return false;
            } else {
                return allValidator(field, fieldObject);
            }
        }

        //CASE 2: (not empty fields) 
        if (isRequired) {
            var validation = BasicValidator(anchors);

            if (validation === true) {
                return allValidator(field, fieldObject);
            } else {
                return false;
            }
        } else {
            //if field is not required
            if ((dataLength > 0)) {

                //do validation;
                var validation;

                if ((validation = BasicValidator(anchors)) !== true) {
                    return validation;
                } else {
                    return allValidator(field, fieldObject)
                }

            } else {
                responseField.html("");
                return allValidator(field, fieldObject);
            }
        }

    }

    function inputAttributes(elem) {

        // field declarations
        let isRequired = ($(elem).attr("required")) ? true : false;
        let formField = indefaults.field;

        // length controllers
        let dataMin = $(elem).attr('data-min') || 0;
        let dataMax = $(elem).attr('data-max') || 1000000000000000000;

        // type controller
        let dataType = ($(elem).attr("type")) ? $(elem).attr("type") : (($(elem).attr("data-type")) ? $(elem).attr("data-type") : "text");

        //  input name
        let fieldName = ($(elem).attr("name")) ? $(elem).attr("name") + " field" : "";
        fieldName = fieldName.replace("_", " ");
        fieldName = ($(elem).attr("data-fieldname")) ? $(elem).attr("data-fieldname") : fieldName;

        // field settings
        let allowSpace = ($(elem).attr("allow-space") == "false") ? false : true; //def: false
        let specialChars = $(elem).attr("allow-chars");
        let allowChars = (specialChars == 'all' || specialChars == '*') ? "all" : ((specialChars == null || specialChars == undefined) ? "text" : specialChars);

        // input data pointers
        let rexPattern = $(elem).attr("data-rex");
        let isNumField = ($(elem).attr('type') == 'number' || $(elem).attr('data-type') == 'number') ? true : false;
        let isPassField = ($(elem).attr('type') == 'password' || $(elem).attr('data-type') == 'password') ? true : false;
        let isTextField = ($(elem).attr('type') == 'text' || $(elem).attr('type') == '' || $(elem).attr('type') == undefined);
        let isTextInput = ($(elem).attr('data-type') == 'text') ? true : false;
        let isTextNum = ($(elem).attr('data-type') == 'text-num') ? true : false;
        let isUrlField = ($(elem).attr('data-type') == 'url') ? true : false;
        let isCreditCard = ($(elem).attr('data-type') == 'credit-card') ? true : false;
        let isMailField = ($(elem).attr('type') == 'email' || $(elem).attr('data-type') == 'email') ? true : false;
        let isTextArea = ($(elem).prop('tagName') == 'TEXTAREA' || $(elem).attr('data-type') == 'textarea') ? true : false;
        let isStrict = (typeof $(elem).attr("data-strict") !== 'undefined' && $(elem).attr("data-strict") !== false) ? true : false;
        let strictValue = (+$(elem).attr("data-strict") === 2) ? 2 : 1;

        // //cards pointers
        // let validCards = ['americaexpress', 'cc', 'discover', 'mastercard', 'verve', 'visa', 'discover'];

        // let amexRex = /^(?:4[0-9]?{12}{})/;
        // let ccRex   = //;
        // let discRex = //;
        // let mastRex = //;
        // let discRex = //;


        //input color object
        let objectFiller = {};
        objectFiller = fillBucket(elem);

        //split the color fill

        var dataValue = ($(elem).val() != null) ? $(elem).val().trim() : null;
        var dataLength = (dataValue == null) ? 0 : dataValue.length;

        if (isTextArea && (specialChars == undefined)) {
            allowChars = "all";
        }

        var dataIndex = formField.find(":input:not(:button):not([data-skip])").index($(elem)) + 1;

        var inputObject = {
            dataInput: $(elem),
            dataIndex: dataIndex,
            dataType: dataType,
            dataValue: dataValue,
            dataLength: dataLength,
            dataMin: dataMin,
            dataMax: dataMax,
            fieldName: fieldName,
            isStrict: isStrict,
            strictValue: strictValue,
            isTextField: isTextField,
            isTextInput: isTextInput,
            isTextNum: isTextNum,
            isNumField: isNumField,
            isPassField: isPassField,
            isUrlField: isUrlField,
            isCreditCard: isCreditCard,
            isMailField: isMailField,
            isTextArea: isTextArea,
            isRequired: isRequired,
            allowSpace: allowSpace,
            allowChars: allowChars,
            rexPattern: rexPattern,
            filler: objectFiller,
        }

        return inputObject;
    }

    function fillBucket(elem) {
        let objectFiller = {};
        formField = indefaults.field;

        //colors controllers
        var colorSets = ['fill', 'text', 'shadow', 'line'];

        var colorSet = $(elem).attr("data-fillset") || formField.attr('data-fillset');
        var colorFill = $(elem).attr("data-fill") || formField.attr('data-fill');

        if (colorSet != false) {
            if (colorFill && colorSet) {

                //split the color filler
                let colors = colorFill.split(" ");

                //ensure that both colors and fill type is set
                if ((colors.length > 0) && colorSets.includes(colorSet)) {

                    objectFiller.type = colorSet;

                    if (colorFill.includes(":")) {

                        //allow shorhand usage
                        let fmColors = colors.map(color => { return color.replace(":", ""); })

                        if (colorSet === 'fill') {
                            if ((fmColors.length === 1)) {
                                objectFiller.success = (fmColors[0] == "-") ? '' : fmColors[0];
                                objectFiller.error = "";
                            } else if ((fmColors.length === 2)) {
                                objectFiller.success = (fmColors[1] == "-") ? '' : fmColors[1];
                                objectFiller.error = (fmColors[0] == "-") ? '' : fmColors[0];
                            }
                        } else {
                            return;
                        }

                    } else if (!colorFill.includes(":") && (colorSet === "fill")) {

                        //filling fields
                        if (colors.length === 1) {
                            objectFiller.success = (colors[0] == "-") ? '' : colors[0];
                        } else if (colors.length === 2) {
                            objectFiller.success = (colors[1] == "-") ? '' : colors[1];
                            objectFiller.error = (colors[0] == "-") ? '' : colors[0];
                        } else if ((colors.length > 2) && (colors.length < 5)) {
                            colors[3] = (typeof colors[3] != 'undefined') ? colors[3] : '';

                            objectFiller.success = (colors[2] == "-") ? '' : colors[2];
                            objectFiller.successText = (colors[3] == "-") ? '' : colors[3];

                            objectFiller.error = (colors[0] == "-") ? '' : colors[0];
                            objectFiller.errorText = (colors[1] == "-") ? '' : colors[1];
                        }
                    } else {
                        if (colors.length == 1) {
                            objectFiller.error = "";
                            objectFiller.success = colors[0];
                        }

                        if (colors.length > 1) {
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

    function BasicValidator(anchors) {

        let input = anchors.dataInput;
        let isRequired = anchors.isRequired;
        let isTextField = anchors.isTextField;
        let isTextInput = anchors.isTextInput;
        let isTextNum = anchors.isTextNum;
        let isUrlField = anchors.isUrlField;
        let isCreditCard = anchors.isCreditCard;
        let isMailField = anchors.isMailField;
        let isPassField = anchors.isPassField;
        let isNumField = anchors.isNumField;
        let isStrict = anchors.isStrict;
        let strictValue = anchors.strictValue;

        let dataIndex = anchors.dataIndex;
        let dataValue = anchors.dataValue;
        let dataLength = anchors.dataLength;
        let dataMin = anchors.dataMin;
        let dataMax = anchors.dataMax;
        let field = indefaults.field;
        let fieldName = anchors.fieldName;
        let responseField = anchors.responseBox;
        let button = anchors.submitBtn;
        let buttonHolder = anchors.buttonHolder;
        let formField = anchors.formField;
        let passFieldCount = anchors.passFieldCount;
        let userPassField1 = anchors.userPassField1;
        let userPassField2 = anchors.userPassField2;
        let validateBtn = anchors.validateBtn;

        //special validation
        let allowSpace = anchors.allowSpace;
        let allowChars = anchors.allowChars;
        let rexPattern = anchors.rexPattern;

        //colors
        let filler = anchors.filler;
        let fill = anchors.fill;

        if (anchors.ajax) {

            let ajaxResp = anchors.ajax;

            anchors.ajax = undefined;

            if (ajaxResp == 'success') {
                //open button

                buttonHolder.attr({ "data-active": "true" });
                (validateBtn == true) ? buttonHolder.removeAttr("disabled"): null;
                (validateBtn == true) ? button.removeAttr("disabled"): null;
                inputFiller(input, true, fill);
            } else {
                (validateBtn == true) ? buttonHolder.attr({ "disabled": "disabled" }): null;
                (validateBtn == true) ? button.attr({ "disabled": "disabled" }): null;
                inputFiller(input, false, fill);
            }

            runChecker(input);
            return;
        }

        //reformat allowChars email to "mail"
        allowChars = (allowChars == "email") ? "mail" : allowChars;

        fieldName = (fieldName == "") ? "field " + dataIndex : fieldName;
        buttonHolder.attr({ "data-active": "false" });
        (validateBtn == true) ? buttonHolder.attr({ "disabled": "disabled" }): null;
        (validateBtn == true) ? button.attr({ "disabled": "disabled" }): null;

        testMail = (isMailField && allowChars == 'mail') ? true : false;

        //field count

        var voids = 0;
        var fieldCount = indefaults.field.find(":input:not(:button):not([data-skip])").length;
        var mshide = "";

        indefaults.allInputs.each(function(index) {
            if (dataIndex < (index + 1)) {
                if ($(this).val().length < 1) {
                    var thisFiller = fillBucket($(this));
                    inputFiller($(this), 'reset', true);
                }
            }
        })

        if (anchors.initMess == false) {

            var iField;
            for (var i = 0; i < fieldCount; i++) {
                iField = indefaults.field.find(":input:not(:button):not([data-skip])").eq(i);
                if (iField.val() == "" || iField.val() == null) {
                    voids = voids + 1;
                }
            }

            if (voids == fieldCount) {

                if (field.find("input[required]").length > 0) {
                    buttonHolder.attr({ "disabled": "disabled" })
                    button.attr({ "disabled": "disabled" });
                }

                responseField.html('');
                inputFiller(input, 'reset', fill);
                return false;
            }
        }

        if (isRequired == false && dataLength < 1) {
            responseField.html("");
            buttonHolder.removeAttr("disabled");
            inputFiller(input, 'reset', fill);
            button.removeAttr("disabled");
            return true;
        }

        if (isCreditCard) {
            if (!/^[0-9]+$/.test(dataValue)) {
                responseField.html(" <span class='form-validator-message'> " + fieldName + " can only contain numbers</span>");
                inputFiller(input, false, fill);
                return false;
            }

            let ccDataValue = dataValue.substring(0, dataValue.lenght - 1);
            let reverseDataValue = ccDataValue.split("").reverse();
            reverseDataValue = reverseDataValue.map((reverse) => {
                if ((reverse % 2) !== 0) {
                    let newverse = reverse * 2;
                    if (newverse > 9) {
                        newverse = newverse - 9;
                    }
                    return newverse;
                } else {
                    return reverse;
                }
            }).reduce((a, b) => a + b, 0); //.join("");

            if ((reverseDataValue % 10) != (ccDataValue.slice(-1))) {
                //credit card is not valid
                responseField.html(" <span class='form-validator-message'> " + fieldName + " not valid</span>");
                inputFiller(input, false, fill);
                return false;
            }

            //International cards
            let visa = /^(?:4[0-9]{12}(?:[0-9]{3})?)$/;
            let mast = /^(?:5[1-5][0-9]{14})$/;
            let amex = /^(?:3[47][0-9]{13})$/;
            let disc = /^(?:6(?:011 | 5[0-9][0-9][0-9]{16,19}))$/;

            //Nigerian card
            let verve = /^(?:(506[0-9][0-9][0-9]{10})|(65002(7)?[0-9]{10, 11}))$/;

            if (!visa.test(dataValue) && !mast.test(dataValue) && !amex.test(dataValue) && !disc.test(disc) && !verve.test(dataValue)) {
                responseField.html(" <span class='form-validator-message'> " + fieldName + " card not recognized </span>");
                inputFiller(input, false, fill);
                return false;
            }

        }

        if (isTextNum) {
            if (!/^[A-Za-z0-9\s]+$/.test(dataValue)) {
                //DO THIS
                responseField.html(" <span class='form-validator-message'> " + fieldName + " can only contain alphabets and numbers</span>");
                inputFiller(input, false, fill);
                return false;
            }
        }

        if (isTextInput && (/\d/.test(dataValue))) {
            responseField.html(" <span class='form-validator-message'> " + fieldName + " must not contain number </span>");
            inputFiller(input, false, fill);
            return false;
        }

        if (isTextInput && isStrict) {
            let strictTest;

            if (strictValue === 2) {
                strictTest = /[ `!@#$%^&*()_+\-=\[\]{};':"\\|,.<>\/?~]/.test(dataValue);
            } else {
                strictTest = /[ `!@#$%^&*()+\-=\[\]{};':"\\|,.<>\/?~]/.test(dataValue);
            }

            if (strictTest == true) {
                responseField.html(" <span class='form-validator-message'> " + fieldName + " must contain only letters </span>");
                inputFiller(input, false, fill);
                return false;
            }
        }

        if (isTextInput && isStrict && (/[ `!@#$%^&*()+\-=\[\]{};':"\\|,.<>\/?~]/.test(dataValue))) {
            responseField.html(" <span class='form-validator-message'> " + fieldName + " must contain only letters </span>");
            inputFiller(input, false, fill);
            return false;
        }

        if (isNumField == true && isNaN(dataValue)) {

            responseField.html(" <span class='form-validator-message'> " + fieldName + " must be number </span>");
            inputFiller(input, false, fill);
            return false;
        }

        if (isNumField == true && dataValue == false && isStrict != false) {
            responseField.html(" <span class='form-validator-message'> " + fieldName + " must be valid </span>");
            inputFiller(input, false, fill);
            return false;
        }

        if (((dataLength < dataMin) || (dataLength > dataMax)) && (dataLength != 0)) {
            if (dataLength < dataMin) {
                responseField.html(" <span class='form-validator-message'> " + fieldName + " is too short </span>");
            }

            if (dataLength > dataMax) {
                responseField.html(" <span class='form-validator-message'> " + fieldName + " is too long  </span>");
            }

            inputFiller(input, false, fill);

            return false;
        }

        if (dataLength < 1) {
            responseField.html("<span class='form-validator-message'> Please fill " + fieldName + " </span>");
            inputFiller(input, false, fill);
            return false;
        }

        if (dataLength > 1 && !isNumField && !testMail) {

            if (allowSpace == false) {
                if (/\s/.test(dataValue)) {
                    responseField.html("<span class='form-validator-message'> invalid space in " + fieldName + "</span>");
                    inputFiller(input, false, fill);
                    return false;
                }
            }

            if (allowChars === 'rex' && rexPattern != undefined) {
                let pattern = "^[" + rexPattern + "]*$";
                var regex = new RegExp(pattern, "i");

                if (regex.test(dataValue) != true) {
                    responseField.html("<span class='form-validator-message'> invalid characters in " + fieldName + "</span>");
                    inputFiller(input, false, fill);
                    return false;
                }
            }

            // if (allowChars == "text" && dataLength > 1) {
            //     if (/^[\w+\s]*$/i.test(dataValue) != true) {
            //         responseField.html("<span class='form-validator-message'> invalid characters in " + fieldName + "</span>");
            //         inputFiller(input, false, fill);
            //         return false;
            //     }
            // } else if (allowChars != "text" && allowChars != 'all') {

            //     if (allowChars == "rex" && rexPattern != undefined) {
            //         var pattern = "^[" + rexPattern + "]*$";
            //     } else {
            //         var pattern = "^[\\w+\\s" + allowChars + "]*$";
            //     }

            //     var regex = new RegExp(pattern, "i");

            //     if (regex.test(dataValue) != true) {
            //         responseField.html("<span class='form-validator-message'> invalid characters in " + fieldName + "</span>");
            //         inputFiller(input, false, fill);
            //         return false;
            //     }
            // }
        }

        if ((isUrlField)) {
            if (!isValidHttpUrl(dataValue)) {
                responseField.html("<span class='form-validator-message'> invalid url supplied in " + fieldName + "</span>");
                inputFiller(input, false, fill);
                return false;
            }
        }


        if ((testMail == true) && (dataLength > 1)) {
            var pattern = /^(([^<>()\[\]\\.,;:\s@"]+(\.[^<>()\[\]\\.,;:\s@"]+)*)|(".+"))@((\[[0-9]{1,3}\.[0-9]{1,3}\.[0-9]{1,3}\.[0-9]{1,3}\])|(([a-zA-Z\-0-9]+\.)+[a-zA-Z]{2,}))$/;
            if (pattern.test(String(dataValue).toLowerCase()) == false) {
                responseField.html("<span class='form-validator-message'> invalid " + fieldName + "</span>");
                inputFiller(input, false, fill);
                return false;
            }

        }


        if (isPassField) {
            //find the other password field and check for matches.
            //get password field
            if (passFieldCount > 1) {
                if ((userPassField1.val() === userPassField2.val()) && (userPassField1.val() != false) && (userPassField1.val() != "undefined")) {
                    //password matched
                    inputFiller(input, true, fill);
                } else {
                    //password mismatch
                    responseField.html("<span class='form-validator-message'> password does not match </span>");
                    if (userPassField1.val() != userPassField2.val()) {
                        let passFiller;

                        if (userPassField1.val().length < 1) {
                            inputFiller(userPassField1, 'reset', fill);
                        } else {
                            inputFiller(userPassField1, false, fill);
                        }

                        if (userPassField2.val().length < 1) {
                            inputFiller(userPassField2, 'reset', fill);
                        } else {
                            inputFiller(userPassField2, false, fill);
                        }
                    }
                    return false;
                }
            }
        }

        //return false;


        if (input.attr('data-url') && (input.attr('data-process') !== 'success')) {

            input.attr({ 'data-process': 'failed' });


            if (!input.attr('data-req')) {
                input.attr({ 'data-req': true });


                let dataUrl = input.data('url');
                let dataKeys = input.data('keys');

                if ((typeof dataKeys == 'undefined') || (dataKeys == false)) {
                    dataKeys = "valid msg";
                }

                dataKeys = $.trim(dataKeys);

                dataKeys = dataKeys.split(' ');

                if (dataKeys.length === 1) { dataKeys[1] = "msg"; }

                let jsonValid = dataKeys[0];
                let jsonError = dataKeys[1];
                console.log(dataKeys)
                console.log(jsonError)

                let timeout = 1500;

                if (dataUrl !== false && typeof dataUrl !== 'undefined') {

                    if (isValidHttpUrl(dataUrl)) {
                        //send url;

                        setTimeout(() => {

                            (validateBtn == true) ? buttonHolder.attr({ "disabled": "disabled" }): null;
                            (validateBtn == true) ? button.attr({ "disabled": "disabled" }): null;

                            if (!input.attr('data-proc')) {

                                input.attr({ 'data-proc': true });

                                $.ajax({
                                    url: dataUrl,
                                    data: { 'input': dataValue },
                                    complete: (XMLHttpRequest) => {
                                        input.removeAttr('data-proc');

                                        response = XMLHttpRequest.responseText;
                                        response = JSON.parse(response);

                                        let dataProcess = 'failed';

                                        valid = response[jsonValid];

                                        if (valid === true) {
                                            dataProcess = 'success';
                                        } else {
                                            let msg = response[jsonError] || 'data validation failed';
                                            responseField.html(msg);
                                            dataProcess = 'failed';
                                        }

                                        input.attr({ 'data-process': dataProcess });

                                        setTimeout(() => {
                                            anchors.ajax = dataProcess;
                                            BasicValidator(anchors);
                                        }, timeout);

                                    }
                                })

                            }
                        }, timeout);

                        inputFiller(input, false, fill);
                        indefaults.errAjax = true;
                        responseField.html('');
                        return false;

                    } else {
                        responseField.html("invalid data request");
                        inputFiller(userPassField2, false, fill);
                        indefaults.errAjax = true;
                        return false;
                    }
                }

            }

        }

        if (indefaults.field.find('[data-process="failed"]').length < 1) {
            //enable button;
            responseField.html("");
            buttonHolder.attr({ "data-active": "true" });
            (validateBtn == true) ? buttonHolder.removeAttr("disabled"): null;
            (validateBtn == true) ? button.removeAttr("disabled"): null;
            inputFiller(input, true, fill);
            return true;
        }

    }

    function range(a, b) {
        if (b === undefined) {
            b = a;
            a = 1;
        }
        return [...Array(b - a + 1).keys()].map(x => x + a);
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

        filler = fillBucket($(input));

        if (action === "reset") {
            if (filler.success || filler.error) {
                input.css({ 'color': '' });
                input.css({ 'background-color': '' });
            }
            input.css({ 'box-shadow': '' });
            return;
        }

        let key1, key2, color, textColor, shadow;

        key1 = (action === true) ? 'success' : 'error';
        key2 = (action === true) ? 'successText' : 'errorText';

        if (filler.shadow) { shadow = filler.shadow }

        if ((key1 === 'success') || (key1 === 'error')) {
            fillColor = filler[key1];
            textColor = filler[key2];

            if (filler.type === 'fill') {
                input.css({ 'background-color': fillColor });
                if (filler.successText || filler.errorText) {
                    input.css({ 'color': textColor });
                }
            } else if (filler.type === 'text') {
                input.css({ "color": color });
                if (shadow) {
                    if (color == '') {
                        input.css({ 'box-shadow': `` });
                    } else {
                        input.css({ 'box-shadow': `0 0 0 ${shadow}px ${color} inset` });
                    }
                }
            } else if (filler.type === 'shadow') {
                input.css({ 'border': `0 0 0 ${shadow}px ${color} inset` });
            }

            if (filler.type === 'shadow') {
                // input.css({ 'box-shadow': `0 0 0 ${shadow}px ${fillColor} inset` });
                if ((key1 != "") && (fillColor != "")) {
                    input.css({ 'box-shadow': `0 0 0 ${shadow}px ${fillColor} inset` });
                } else {
                    input.css({ 'box-shadow': '' });
                }
            }
        }



    }

    function isButton(selector) {

        itemName = selector.prop('tagName');
        itemAttr = selector.attr('type');

        if (item == "") { return; }

        item = item.toLowerCase();

        if (itemName == 'button') return true;

        if (itemName == 'input' && itemAttr == 'submit') return true;

        return false;
    }

    function allValidator(field, fieldObject) {

        //validate
        indefaults.allInputs.each(function() {

            //set inputAttributes
            anchors = inputAttributes(this);

            //set fieldObject into anchors
            anchors.responseBox = fieldObject.responseBox;
            anchors.submitBtn = fieldObject.submitBtn;
            anchors.buttonHolder = fieldObject.buttonHolder;
            anchors.passFieldCount = fieldObject.passFieldCount;
            anchors.userPassField1 = fieldObject.userPassField1;
            anchors.userPassField2 = fieldObject.userPassField2;
            anchors.validateBtn = fieldObject.validateBtn;
            anchors.initMess = fieldObject.initMess || false;
            anchors.fill = fieldObject.fill;

            fill = anchors.fill;

            if (anchors.isRequired === false) {
                if (anchors.dataLength > 0) {
                    return BasicValidator(anchors);
                }
                fieldObject.responseBox.html("");
                fieldObject.buttonHolder.attr({ "data-active": "true" });

                (fieldObject.validateBtn == true) ? fieldObject.submitBtn.removeAttr("disabled"): null;
                (fieldObject.validateBtn == true) ? fieldObject.buttonHolder.removeAttr("disabled"): null;
                inputFiller(input, 'reset', fill);
                return true;
            }

            return BasicValidator(anchors);

        })

    }

    var indefaults = {
        responseField: ""
    }


    /*
     accepted attributes
     data-min // minimum input value
     data-max // maximum input value
     data-type // input type (used to specify attributes in cases where user needs to specify type of data to be allowed in the input)
       data-type may be (number,text,password) etc. 

     required // for required fields to be validated
    NOTE: Numeric field will not be allowed to have characters included. Any addition of characters will reset the field
    */

})(jQuery)


/*This function uses data-form="validate" to validate forms*/
function formValidator() {
    if ($("[data-form='validate']").length < 1) { return false; }

    $("[data-form='validate']").each(function() {
        var thisForm = $(this);
        var thisId = thisForm.data("id") || thisForm.attr("id");

        thisForm.find(":input:not(:button):not([data-skip])").on('input keyup', function() {
            let inputForm = $(this).closest("[data-form]");
            if (thisForm.attr('data-pick') !== 'true') {
                thisForm.removeAttr('data-pick');
                inputForm.attr({ 'data-pick': true });
                let newresPane = inputForm.data("resp") || false;
                console.log(newresPane)
                inputForm.validateForm({ responsePane: newresPane });
            }
        })

        var tId = thisForm.data("id") ? '[data-id="' + thisId + '"]' : '#' + thisId;
        var tForm = (thisId) ? tId : thisForm;
        var resPane = thisForm.data("resp") || false;
        var dataForm = $(tForm).validateForm({ responsePane: resPane });
    })
}