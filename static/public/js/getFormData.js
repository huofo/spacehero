

    //获取指定form中的所有的<input>对象
    function getElements(formId) {
        var form = document.getElementById(formId);
        var elements = new Array();
        var tagElements = form.getElementsByTagName('input');
        for (var j = 0; j < tagElements.length; j++){
            elements.push(tagElements[j]);

        }
        return elements;
    }

//获取单个input中的【name,value】数组
function inputSelector(element) {
    if (element.checked)
        return [element.name, element.value];
}

function input(element) {
    switch (element.type.toLowerCase()) {
        case 'submit':
        case 'hidden':
        case 'password':
        case 'text':
            return [element.name, element.value];
        case 'checkbox':
        case 'radio':
            return inputSelector(element);
    }
    return false;
}

//组合URL
function serializeElement(element) {
    var method = element.tagName.toLowerCase();
    var parameter = input(element);

    if (parameter) {
        var key = encodeURIComponent(parameter[0]);
        if (key.length == 0) return;

        if (parameter[1].constructor != Array)
            parameter[1] = [parameter[1]];

        var values = parameter[1];
        var results = [];
        for (var i=0; i<values.length; i++) {
          //  results[key] = encodeURIComponent(values[i]);
            results.push(key + '=' + encodeURIComponent(values[i]));
        }
        return results.join('&');
        //return results;
    }
}

//生成 数组
    function create_arr(element) {
        var method = element.tagName.toLowerCase();
        var parameter = input(element);

        if (parameter) {
            var key = (parameter[0]);
            if (key.length == 0) return;

            if (parameter[1].constructor != Array)
                parameter[1] = [parameter[1]];

            var values = parameter[1];
            var result = [];

                result.push(key);
                result.push((values[0]));

              //  results.push(key + '=' + encodeURIComponent(values[i]));

            //return results.join('&');
            return result;
        }
    }


//调用方法
function serializeForm(formId) {
    var elements = getElements(formId);

    var queryComponents = new Array();

    for (var i = 0; i < elements.length; i++) {
        var queryComponent = serializeElement(elements[i]);
        if (queryComponent)
            queryComponents.push(queryComponent);
    }

    return queryComponents.join('&');
}

    function getFormData(formId) {
        var elements = getElements(formId);

        var queryComponents = new Array();

        for (var i = 0; i < elements.length; i++) {
            queryComponent = create_arr(elements[i],queryComponents);
            if (queryComponent)
                queryComponents[queryComponent[0]] = queryComponent[1];
                //queryComponents.push(queryComponent);
        }

        return queryComponents;//.join('&');
    }

