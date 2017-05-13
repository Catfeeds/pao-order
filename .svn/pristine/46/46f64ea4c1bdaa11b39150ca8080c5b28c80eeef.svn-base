/**
 * Created by Administrator on 2016/11/16.
 */
function submitPayInfo(obj){
    var type = $(obj).data("paytype");
    console.log(type);
    var formData;
    if(type == 'wxpay'){
        var formName1 = "wxpayForm";
        var form1 = $("#"+formName1)[0];
        formData = new FormData(form1);
    }else{
        var formName2 = "alipayForm";
        var form2 = $("#"+formName2)[0];
        formData = new FormData(form2);
    }
    console.log(formData);
    $.ajax({
        url:"/index.php/admin/DataDock/editAddPayInfo/type/"+type,
        data:formData,
        type:'post',
        dataType:'json',
        contentType:false,
        cache:false,
        processData:false,
        success:function(data){
            console.log(data);
        },
        error:function(){
            console.log("网络出错了");
        }
    });
}