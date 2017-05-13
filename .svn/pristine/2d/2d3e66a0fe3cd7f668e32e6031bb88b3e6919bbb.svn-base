  //新增菜品类别模态框
  function add_food_type(){
  		var food_id = $("#type_form").data('id');
  		if(food_id != undefined){
  			$("#add-dishes-sort").modal('show');
	  		$("#reset1").trigger("click");
	  		$(".attr-upload").children().attr('src',"");
  		}else{
  			alert("请先保存菜品的基本信息！");
  		}
  }
  
  
  //编辑菜别属性
  function editAttr(obj){
        var food_attribute_id = $(obj).data("attr_id");
        $("#food_attribute_id").val(food_attribute_id);
        $("#type").val("edit");
        $.ajax({
        	type:"get",
        	url:"/index.php/admin/dishes/getDishesAttr/food_attribute_id/"+food_attribute_id+"",
        	async:true,
        	success:function(data){
        		$("input[name='attribute_name']").val(data.attribute_name);    		
        		$("input[name='attribute_price']").val(data.attribute_price);
        		$("input[name='food_attribute_id']").val(data.food_attribute_id);
        		$("#attrimg").attr('src',"/"+data.attribute_img+"");
        	}
        });
    }


    function addDishesAttr1(obj){
        var attribute_type_id = $(obj).data("type_id");
        console.log("类别id:"+attribute_type_id);
        $("#attribute_type_id").val(attribute_type_id);
        console.log($("#attribute_type_id").val(attribute_type_id));
        $("#type").val("add");
        $("#reset2").trigger("click");
    }

    function addDishesAttr(obj){
        $("#edit-attr").modal("hide");
        var type = $("#type").val();
        var form = $("#add_attr")[0];
        var formData = new FormData(form);
        console.log("值"+$("#type_form").val());
        var url;
//        console.log(url);
        if(type == "add"){
            url = '/index.php/admin/dishes/addDishesAttr';
            $.ajax({
                url:url,
                type:'post',
                data:formData,
                dataType:'json',
                contentType:false,
                processData:false,
                cache:false,
                async:false,
                success:function(msg){
                    console.log(msg);
                    if(msg.code == 1){
                        var data = msg.data;
                        var str = '<button class="btn btn-sm btn-default" data-toggle="modal" data-target="#edit-attr" data-attr_id="'+data['food_attribute_id']+'" onclick="editAttr(this)">'+data['attribute_name']+'</button>';
                        $("#attrType"+data['attribute_type_id']).append(str);
                    }
                },
                error:function(){
                    console.log("访问出错了");
                }
            });
        }else if(type == "edit"){
            var food_id = $("#type_form").data("id");
            url = '/index.php/admin/dishes/editDishesAttr';
            $.ajax({
                url:url,
                type:'post',
                data:formData,
                dataType:'json',
                contentType:false,
                processData:false,
                cache:false,
                async:false,
                success:function(msg){
                    console.log(msg);
                    if(msg.code == 1){
                        self.location.href = "/index.php/admin/Dishes/edit/food_id/"+food_id;
                    }
                },
                error:function(){
                    console.log("访问出错了");
                }
            });
        }

    }

    function editType(obj){
        var type_id = $(obj).data('type_id');
        $.ajax({
            url:"/index.php/admin/Dishes/getTypeAttrs",
            type:"post",
            data:{"type_id":type_id},
//            dataType:"json",
            success:function(data){
                $("#attr_content_byId").html(data);
            },
            error:function(){
                console.log("访问出错");
            }
        });
    }

    function editDishesType(){
        var food_id = $("#type_form").data('id');
        var form = $("#editDishesType")[0];
        var formData = new FormData(form);
        formData.append("food_id",food_id);
        $.ajax({
            url:"/index.php/admin/dishes/editDishesType",
            type:"post",
            data:formData,
            dataType:"json",
            contentType:false,
            processData:false,
            cache:false,
            success:function(msg){
                if(msg.code == 1){
                    self.location.href = "/index.php/admin/Dishes/edit/food_id/"+food_id;
                }
            },
            error:function(){
                console.log("访问出错");
            }
        });
    }

    function deleteAttr(obj){
        var attr_id = $(obj).data("attr_id");
        $.ajax({
            url:"/index.php/admin/dishes/deleteAttr",
            data:{"attr_id":attr_id},
            type:"post",
            dataType:"json",
            success:function(msg){
                if(msg.code == 1){
                    $(obj).parent().remove();
                }
            },
            error:function(){
                console.log();
            }
        });
    }

    function deleteType(obj){
        var type_id = $(obj).data("type_id");
        $.ajax({
            url:"/index.php/admin/dishes/deleteType",
            data:{"type_id":type_id},
            type:"post",
            dataType:"json",
            success:function(msg){
                if(msg.code == 1){
                    $(obj).parent().parent().remove();
                }
            },
            error:function(){
                console.log();
            }
        });
    }
    
    //新增菜品页面-新增菜品类别
    function addDishesAttrType(){
        $("#add-dishes-sort").modal("hide");
        var form = $("#addDishesAttrType")[0];
        var food_id = $("#type_form").data('id');
        $("#type_form").val(food_id);
        var formData = new FormData(form);
        $.ajax({
            url:'/index.php/admin/dishes/addDishesAttrType',
            data:formData,
            type:"post",
            dataType:'json',
            contentType:false,
            processData:false,
            cache:false,
            async:false,
            success:function(msg){
                console.log(msg);
                if(msg.code == 1){
                    console.log("操作成功");
                    var data = msg.data;
                    var str = '<tr><td> <b>'+data['type_name']+'</b>'
                            +'</td>'
                            +'<td id="attrType'+data["attribute_type_id"]+'">'
                            +'</td>'
                            +'<td>'
                            +'<button class="btn btn-sm btn-info" data-toggle="modal" data-target="#edit-attr" data-type_id="'+data["attribute_type_id"]+'"onclick="addDishesAttr1(this)">新增属性</button> '
                            +'<button class="btn btn-sm btn-primary" data-toggle="modal" data-target="#edit-dishes-sort" data-type_id="'+data["attribute_type_id"]+'" onclick="editType(this)">编辑</button> '
                            +'<button class="btn btn-sm btn-danger" data-type_id="'+data["attribute_type_id"]+'" onclick="deleteType(this)">删除</button>'
                            +'</td>'
                            +'</tr>';
                    $("#dishesAttrList").append(str);
                }
            },
            error:function(){
                console.log("访问出错了");
            }
        });
    }
    
    

    function select_all(obj){
        var tt = $(obj).val();
        if (tt == 0) {
            $(".menu_input").prop("checked", true);
            $(obj).val(1);
        } else if (tt == 1) {
            $(".menu_input").prop("checked", false);
            $(obj).val(0)
        }
    }

    function preview(file) {
        var prevDiv = document.getElementById('preview');
        if (file.files && file.files[0]) {
            var reader = new FileReader();
            reader.onload = function (evt) {
                prevDiv.innerHTML = '<img src="' + evt.target.result + '"/>';
            }
            reader.readAsDataURL(file.files[0]);
        }
    }
    function mypreview(file) {
        var prevDiv = $(file).parent().prev();
        console.log();
        prevDiv = prevDiv[0];
        console.log(prevDiv);
        if (file.files && file.files[0]) {
            var reader = new FileReader();
            reader.onload = function (evt) {
                prevDiv.innerHTML = "";
                prevDiv.innerHTML = '<img src="' + evt.target.result + '" class="pre100 center-block" style="width:100%;height:100%;" />';
            }
            reader.readAsDataURL(file.files[0]);
        }
        else {
            prevDiv.innerHTML = "";
            prevDiv.innerHTML = '<div style="width:100%;height:100%;" class="img" style="filter:progid:DXImageTransform.Microsoft.AlphaImageLoader(sizingMethod=scale,src=\'' + file.value + '\'"></div>';
        }
    }
    
    $("input[name='is_prom']").change(function(){
    	//alert($(this).val());
    	var value = $(this).val();
    	if(value == 1){
    		$("#showdiscount").show();
    	}else{
    		$("#showdiscount").hide();
    	}
    });
    
