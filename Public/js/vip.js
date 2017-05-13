// 将各类型的设置传递到数据库
function to_db(a,b,url){
    // 判断是if_open还是if_vip
    if(a == "if_open"){
        // 发送ajax
        $.post(url,{"if_open":b},function(data){
            if(data.status == 0){
                alert(data.info);
            }
        });
    }else if(a == "if_vip"){
        // 发送ajax
        $.post(url,{"if_vip":b},function(data){
            if(data.status == 0){
                alert(data.info);
            }
        });
    }
}

