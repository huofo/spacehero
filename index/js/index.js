/**
 * 说明：该页面是form提交，已经提交后提示结果的js代码，引用该js代码前记得去style.css，拷贝《ajax加载结果弹框》css样式
 */


//定时器id
var error_id = "";

/**
 * 生成提示框
 * title 提示标题
 */
function ajaxConfirm(title){
    var newDiv=document.createElement("div");
    newDiv.setAttribute("id","ajaxconfirm");
    document.body.appendChild(newDiv);
    newDiv.style.height="100%";
    newDiv.style.width="100%";
    newDiv.style.position = "fixed";
    newDiv.style.top = "0";
    newDiv.style.left = "0";
    newDiv.style.display = "block";
    newDiv.style.zIndex = "9997";
    var msg_bg=document.createElement("div");
    document.getElementById("ajaxconfirm").appendChild(msg_bg);
    msg_bg.style.height="100%";
    msg_bg.style.width="100%";
    msg_bg.style.position = "absolute";
    msg_bg.style.top = "0";
    msg_bg.style.left = "0";
    msg_bg.style.background = "#000";
    msg_bg.style.zIndex = "9998";
    msg_bg.style.opacity = "0.1";
    var msg_text=document.createElement("div");
    document.getElementById("ajaxconfirm").appendChild(msg_text);
    msg_text.style.minHeight="140px";
    msg_text.style.width="360px";
    msg_text.style.zIndex = "9999";
    msg_text.style.background = "#fff";
    msg_text.style.position = "absolute";
    msg_text.style.marginLeft = "-180px";
    msg_text.style.boxShadow = "0 0 5px #888";
    msg_text.style.top = "30%";
    msg_text.style.left = "50%";
    msg_text.innerHTML="<div style='width:350px;height:35px;padding:0 5px;line-height:35px;background:#ff6600;color:#fff;font-size:14px;font-weight:bold;'>jind_ts<span onclick='ajaxConfirmRemove()' class='msg_remove'>×</span></div><div style='word-break:break-all;width:330px;min-height:30px;margin:15px;line-height:30px;font-size:16px;color:#444444;text-align: center;font-weight:bold;'>"+title+"</div><div style='width:350px;height:45px;padding:0 5px;background:#eeeeee;'><input id='msg_confirm_button_no' class='msg_confirm_button' type='button' value=bi_qx/><input id='msg_confirm_button_ok' class='msg_confirm_button' type='button' value=bi_qd/></div>";
}
/**
 * 关闭提示框
 */
function ajaxConfirmRemove(){
    var ajaxconfirm = document.getElementById("ajaxconfirm");
    ajaxconfirm.parentNode.removeChild(ajaxconfirm);
}
/**
 * 确定按钮事件
 * callback 点击确定之后要执行的方法,所以此处传入的是一个方法
 */
var btnOk = function(callback){
    $("#msg_confirm_button_ok").click(function(){
        ajaxConfirmRemove();
        if (typeof (callback) == 'function'){
            callback();
        }
    });
};
/**
 * 取消按钮事件
 */
var btnNo = function(){
    $("#msg_confirm_button_no").click(function(){
        ajaxConfirmRemove();
    });
};
/**
 * 确定/取消选择
 * title 提示标题
 * callback 点击确定之后要执行的方法,所以此处接收的是一个方法
 */
$.MsgBox = {
    Confirm: function (title,callback){
        ajaxConfirm(title);
        btnOk(callback);
        btnNo();
    }
};
/**
 *执行失败消息提示框
 */
function errorMsg(message,link){
    var errormsg = document.getElementById("errormsg"); //防止重复生成弹框
    if(errormsg != null){
        errormsg.parentNode.removeChild(errormsg);
    }
    var newDiv=document.createElement("div");
    newDiv.setAttribute("id","errormsg");
    document.body.appendChild(newDiv);
    newDiv.style.height="100%";
    newDiv.style.width="100%";
    newDiv.style.position = "fixed";
    newDiv.style.top = "0";
    newDiv.style.left = "0";
    newDiv.style.display = "block";
    newDiv.style.zIndex = "9997";
    var msg_bg=document.createElement("div");
    document.getElementById("errormsg").appendChild(msg_bg);
    msg_bg.style.height="100%";
    msg_bg.style.width="100%";
    msg_bg.style.position = "absolute";
    msg_bg.style.top = "0";
    msg_bg.style.left = "0";
    msg_bg.style.background = "#000";
    msg_bg.style.zIndex = "9998";
    msg_bg.style.opacity = "0.1";
    var msg_text=document.createElement("div");
    document.getElementById("errormsg").appendChild(msg_text);
    msg_text.style.minHeight="124px";
    msg_text.style.width="360px";
    msg_text.style.zIndex = "9999";
    msg_text.style.background = "rgba(0,0,0,0.8)";
    msg_text.style.position = "absolute";
    msg_text.style.borderRadius = "5px";
    msg_text.style.marginLeft = "-180px";
    msg_text.style.boxShadow = "0 0 15px #fff";
    msg_text.style.top = "35%";
    msg_text.style.left = "50%";
    msg_text.innerHTML="<span title=gs_gb onclick='errorRemove(\""+link+"\")' style='float:right;margin:5px 8px 0 0;font-size:16px;color:#bce7f6;cursor:pointer;'>×</span><div style='word-break:break-all;width:300px;padding:5px 10px;min-height:40px;margin:36px 19px;border-radius:3px;border:1px solid #abcdd8;line-height:40px;font-size:20px;background:#c92f2f;color:#fff;text-align: center;font-weight: 200;'>"+message+"</div>";
}
/**
 * 关闭错误提示框
 * link 跳转链接 默认为空，为空则不跳转
 */
function errorRemove(link){
    clearTimeout(error_id);
    var errormsg = document.getElementById("errormsg");
    if(errormsg != null){
        errormsg.parentNode.removeChild(errormsg);
        if(link){
            window.location.href = link;
        }
    }
}
/**
 *执行成功消息提示框
 */
function succeedMsg(message,link){
    var newDiv=document.createElement("div");
    newDiv.setAttribute("id","succeedmsg");
    document.body.appendChild(newDiv);
    newDiv.style.height="100%";
    newDiv.style.width="100%";
    newDiv.style.position = "fixed";
    newDiv.style.top = "0";
    newDiv.style.left = "0";
    newDiv.style.display = "block";
    newDiv.style.zIndex = "9997";
    var msg_bg=document.createElement("div");
    document.getElementById("succeedmsg").appendChild(msg_bg);
    msg_bg.style.height="100%";
    msg_bg.style.width="100%";
    msg_bg.style.position = "absolute";
    msg_bg.style.top = "0";
    msg_bg.style.left = "0";
    msg_bg.style.background = "#000";
    msg_bg.style.zIndex = "9998";
    msg_bg.style.opacity = "0.1";
    var msg_text=document.createElement("div");
    document.getElementById("succeedmsg").appendChild(msg_text);
    msg_text.style.minHeight="124px";
    msg_text.style.width="360px";
    msg_text.style.zIndex = "9999";
    msg_text.style.background = "rgba(0,0,0,0.8)";
    msg_text.style.position = "absolute";
    msg_text.style.borderRadius = "5px";
    msg_text.style.marginLeft = "-180px";
    msg_text.style.boxShadow = "0 0 15px #fff";
    msg_text.style.top = "35%";
    msg_text.style.left = "50%";
    msg_text.innerHTML="<span title=gs_gb onclick='succeedRemove(\""+link+"\")' style='float:right;margin:5px 8px 0 0;font-size:16px;color:#bce7f6;cursor:pointer;'>×</span><div style='word-break:break-all;width:300px;padding:5px 10px;min-height:40px;margin:36px 19px;border-radius:3px;border:1px solid #abcdd8;line-height:40px;font-size:20px;background:#19a50d;color:#fff;text-align: center;font-weight: 200;'>"+message+"</div>";
}
/**
 * 关闭成功提示框
 * link 跳转链接 默认为空，为空则不跳转
 */
function succeedRemove(link){
    var errormsg = document.getElementById("succeedmsg");
    errormsg.parentNode.removeChild(errormsg);
    if(link){
        window.location.href = link;
    }
}
/**
 * 自动关闭成功提示弹框
 * s 剩余秒数
 * link 跳转链接
 */
function automaticSucceedClose(s,link){
    if(s == 0){
        succeedRemove(link);
        return false;
    }
    s--;
    setTimeout('automaticSucceedClose('+s+',"'+link+'")',1000);
}
/**
 * 自动关闭失败提示弹框
 * s 剩余秒数
 * link 跳转链接
 */
function automaticErrorClose(s,link){
    if(s == 0){
        errorRemove(link);
        return false;
    }
    s--;
    error_id = setTimeout('automaticErrorClose('+s+',"'+link+'")',1000);
}
/**
 * 数据提交成功提示框
 * success 是否成功，true是  false不是
 * link 跳转链接 默认为空，为空则不跳转
 */
function message(success,message,link){
    if(success){
        succeedMsg(message,link);
        automaticSucceedClose(2,link);
    }else{
        errorMsg(message,link);
        automaticErrorClose(3,link);
    }
}
/**
 *AJAX执行时加载提示框
 */
function load(){
    var loadDiv=document.createElement("div");
    loadDiv.setAttribute("id","load_ajax");
    document.body.appendChild(loadDiv);
    loadDiv.style.height="32px";
    loadDiv.style.width="32px";
    loadDiv.style.padding="34px";
    loadDiv.style.position = "fixed";
    loadDiv.style.top = "40%";
    loadDiv.style.left = "50%";
    loadDiv.style.marginLeft = "-50px";
    loadDiv.style.background = "#000";
    loadDiv.style.borderRadius = "8px";
    loadDiv.style.zIndex = "9997";
    loadDiv.style.opacity = "0.8";
    loadDiv.style.textAlign = "center";
    loadDiv.style.lineHeight = "32px";
    loadDiv.style.fontSize = "40px";
    loadDiv.innerHTML="<img src='/module/images/loading.gif'>";
}
/**
 *AJAX执行完毕
 */
function finish(){
    var succ = document.getElementById("load_ajax");
    succ.parentNode.removeChild(succ);
    $("input[type='submit']").attr("disabled",false);    //ajax执行完毕，恢复submit按钮
}
/**
 * 退出系统
 * root 网站所在目录
 */
function exit(siteroot){
    $.MsgBox.Confirm(jin_qdtcxtm,function(){window.location.href=siteroot+"index/login/op/exit.html";});
    return false;
}
/**
 * 发送邮箱验证码
 */
function getPhoneCode(siteroot){
    var phone = $("input[name='phone']").val();
    AjaxVisitServer({
        url:siteroot+"index/lostpasswd/op/phone.html",
        data:"phone="+phone
    });
}
/**
 * 发送邮箱验证码
 */
function getEmailCode(siteroot){
    var email = $("input[name='email']").val();
    AjaxVisitServer({
        url:siteroot+"index/lostpasswd/op/email_code.html",
        data:"email="+email
    });
}
/**
* 确认提示
*/
function ExecuteConfirm(options){
    $.MsgBox.Confirm(options.title,function(){AjaxVisitServer(options);});
    return false;
}
/**
 * 字符串格式的时间转为时间戳
 */
function get_unix_time(dateStr){
    if(dateStr == "")return "";
    var newstr = dateStr.replace(/-/g,'/');
    var date =  new Date(newstr);
    var time_str = date.getTime().toString();
    return time_str.substr(0, 10);
}
/**
 * 判断邮箱是否正确
 */
function checkPhone(phone){
    var inp_phone = /^1[3456789]\d{9}$/;
    if(!inp_phone.exec(phone)){
        return false;
    }else{
        return true;
    }
}
/**
 * 判断邮箱是否正确
 */
function checkEmail(email){
    var inp_email = /^([0-9A-Za-z\-_\.]+)@([0-9A-Za-z\-_\.]+)(\.){1}[a-zA-Z]{2,3}$/;
    if(!inp_email.exec(email)){
        return false;
    }else{
        return true;
    }
}
/**
 * 判断密码长度是6-15位数
 */
function check_password(password){
    var inp_password = /^[\S]{6,15}$/;
    if(!inp_password.exec(password)){
        return false;
    }else{
        return true;
    }
}
/**
 * ajax访问服务器处理数据
 */
function AjaxVisitServer(options){
    var datas = "null=null";
    if(options.data != '' && typeof(options.data) != 'undefined'){
        datas = options.data;
    }
    $.ajax({
        type: "POST",
        async: true,
        dataType:'json',
        url: options.url,
        data: datas,
        beforeSend:function(){                           //正在执行请求事件
            load();
        },
        complete:function(){                             //执行完成事件
            finish();
        },
        success: function(json){
            message(json.success,json.message,json.link);   //消息提示
        }
    });
}
$(function(){
    //前台表单数据AJAX提交(公用)
    function formSubmit(form){
        $("input[type='submit']").attr("disabled",true);    //ajax执行时，submit按钮暂时失效
        var self = $(form),
            action = self.attr('action');
        var dataarr = self.serialize();
        $.ajax({
            type: "POST",
            async: true,
            dataType:'json',
            url: action,
            data: dataarr,
            beforeSend:function(){                           //正在执行请求事件
                load();
            },
            complete:function(){                             //执行完成事件
                finish();
            },
            success: function(json){
                message(json.success,json.message,json.link);   //消息提示
            }
        });
        return false;
    }
    //触发表单提交ajax
    var ajax_form = $("form[data-render='ajax']");
    ajax_form.on('submit', function(){
        var self = $(this);
        formSubmit(self);    //通过ajax提交数据
        return false;
    });
});