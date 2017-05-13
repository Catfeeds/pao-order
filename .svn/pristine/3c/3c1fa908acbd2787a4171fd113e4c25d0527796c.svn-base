
// function preview(file) {
//     console.log(file.files[0]);
//     var prevDiv = $(file).parent().prev()[0];
// //        console.log(prevDiv);
//     if (file.files && file.files[0]) {
//         var reader = new FileReader();
//         reader.onload = function (evt) {
//             // prevDiv.innerHTML = '<img src="' + evt.target.result + '" style="width:100%;height:100%" />';
//             $('#edit_upload_box').attr("src",evt.target.result);
//         }
//         reader.readAsDataURL(file.files[0]);
//     }
//     else {
//         prevDiv.innerHTML = '<div class="img" style="filter:progid:DXImageTransform.Microsoft.AlphaImageLoader(sizingMethod=scale,src=\'' + file.value + '\'"></div>';
//     }
// }



function showtime(){
    document.getElementById('show1').style.display = "";
}
function hiddentime(){
    document.getElementById('show1').style.display = "none";
}
function showtime2(){
    document.getElementById('show2').style.display = "";
}
function hiddentime2(){
    document.getElementById('show2').style.display = "none";
}






function modify1(c){
    $('#way').val(1);
    $.ajax({
        type: "post",
        url: "/index.php/admin/dishes/updDishestype",
        data: {"food_category_id": c},
        success: function (data) {
            console.log(data.restaurant_id);
            //$("input[name='Restaurant']").attr("value",data.restaurant_id);
            $('#restaurant_id').attr("value",data.restaurant_id);  
            $('#food_category_id').attr("value",data.food_category_id);
            $('#food_category_name').attr("value",data.food_category_name);
            $("#edit_upload_box").attr('src',"/"+data.image);
            //$("#d").attr('action',"/index.php/admin/dishes/modifyDishestype/food_category_id/"+data.food_category_id);
            //$("#food_category_id").attr("value",data.food_category_id);
            if(data.is_timing == 1){
                $("input[name='is_timing']:eq(1)").prop("checked",true);
                $("#show2").show();
                $("#time").html("");
                if(data.category_time){
                    $.each(data.category_time,function(k,v){
                        var time1 = v['time1'];
                        var time2 = v['time2'];
                        var str = '<div style="margin-top: 5px"> <label for="startTime">开始时间：</label><input type="text" class="startTime" id="startTime" name="startTime" value="'+time1+'"> <label for="endTime">结束时间：</label><input type="text" name="endTime" class="endTime" id="endTime" value="'+time2+'"> </div>';
                        $("#time").append(str);
                    });
                    triggerTime();
                }

                $("#day").html("");
                if(data.category_timing){
                    $.each(data.category_timing,function(){
                        var str = '<div style="margin-top: 5px"> <input type="checkbox" name="monday" value="1"><label >星期一</label>'
                            +'<input type="checkbox" name="tuesday" value="2"><label>星期二</label>'
                            +'<input type="checkbox" name="wednesday" value="3"><label>星期三</label>'
                            +'<input type="checkbox" name="thursday" value="4"><label >星期四</label>'
                            +'<input type="checkbox" name="friday" value="5"><label>星期五</label>'
                            +'<input type="checkbox" name="saturday" value="6"><label >星期六</label>'
                            +'<input type="checkbox" name="sunday" value="0"><label >星期日</label>'
                            +'<select name="dayStartTime" id="">'+
                            '</select> 至' +
                            ' <select name="dayEndTime" id="">'+
                            '</select></div>';
                        $("#day").append(str);
						triggerDay();
                    });

                    $.each(data.category_timing,function(k1,v1){
                        var timingDay = v1['timing_day'];
                        var dayStartTime = v1['start_time'];
                        var dayEndTime = v1['end_time'];
                        $.each(timingDay,function(k2,v2){
                            $("#day div").eq(k1).find("input").each(function(){
                                if($(this).val() == v2){
                                    $(this)[0].checked = true;
                                }
                            });
                        });

                        $("#day select").each(function(k5,v5){
							console.log(v5);
                            if(k5 == 0){
                                $(this).children().each(function(){
                                    if($(this).html() == dayStartTime){
										console.log("f1");
                                        $(this)[0].selected = true;
                                    };
                                });
                            }else{
                                $(this).children().each(function(){
                                    if($(this).html() == dayEndTime){
										console.log("f2");
                                        $(this)[0].selected = true;
                                    };
                                });
                            }
                        });
                    });
                }
            }else{
                $("input[name='is_timing']:eq(0)").prop("checked",true);
            }
        },
        error:function(){
            alert("出错了");
        }
    });
}



function deltype(cid){
    var msg = "您真的确定要删除吗？\n\n请确认！";
    console.log(cid);
    if (confirm(msg)==true){
        $.ajax({
            type:"get",
            url:"/index.php/admin/dishes/delDishestype/food_category_id/"+cid+"",
            success:function(data){
            	if(data == 1){
            		alert("无法删除拥有子集的分类");
            	}else{
               	 	$('#mytype').html(data);
                }
            },
            error:function(){
                alert("出错了");
            }
        });
    }
}

	//改变菜品上下架操作
	function changestatu(i){
		var food_category_id = $("#food_category_id").val();
		if(food_category_id == ""){
			food_category_id = 0;
		}else{
			food_category_id = food_category_id;
		}
		var page = parseInt($('.current').data('page'));
		if(page == "NaN"){
			page == 1;
		}else{
			page = parseInt($('.current').data('page'));
		}
			var msg = confirm('确定要更改菜品状态吗？');
			if(msg == true){
				$.ajax({
					type:"get",
					url:"/index.php/admin/Dishes/updstate/food_id/"+i+"/food_category_id/"+food_category_id+"/page/"+page+"",
					async:true,
					success:function(data){
							$('#all').html(data);
					}
				});
			}
		}
		
	//删除菜品表信息
	function delfoodinfo(food_id){
	
		var food_category_id = $("input[name='food_category_name']").val();
		var tr_leng = $("#mytr").children().children('tr').length;
		console.log(tr_leng);
		if(tr_leng > 2){
			var page = parseInt($('.current').text());
		}else{
			var page = parseInt($('.current').text()-1);
		}
		var msg = confirm('确定要删除此菜品吗？');
		if(msg == true){
				$.ajax({
					type:"get",
					url:"/index.php/admin/Dishes/delfoodinfo/food_id/"+food_id+"/page/"+page+"",
					async:true,
					success:function(data){
							$('#all').html(data);
					}
				});		
			}
		}
		
	//删除菜品关联表信息
	function delfoodinfo1(id){	
		var food_category_id = $("input[name='food_category_name']").val();
		var tr_leng = $("#mytr").children().children('tr').length;
		console.log(tr_leng);
		if(tr_leng > 2){
			var page = parseInt($('.current').text());
		}else{
			var page = parseInt($('.current').text()-1);
		}
		console.log(food_category_id);
		console.log(page);
		var msg = confirm('确定要删除此菜品吗？');
		if(msg == true){
				$.ajax({
					type:"get",
					url:"/index.php/admin/Dishes/delfoodinfo1/id/"+id+"/food_category_id/"+food_category_id+"/p/"+page+"",
					async:true,
					success:function(data){
							$('#all').html(data);
					}
				});		
			}
		}
	
/*	function moveup(obj){ 
    	var $tr = $(obj).parents("tr"); 
	    if ($tr.index() != 1) { 
	      $tr.fadeOut().fadeIn(); 
	      $tr.prev().before($tr);    
	    } 
	} */

	
	
	//菜品分类数据上移
	function moveup1(obj){
		var sort = $(obj).data('sort');
		var food_category_id = $(obj).data('food_category_id');
    	var tr = $(obj).parents("tr");
    	console.log(tr.index());
    	/*console.log(tr.index());*/
	   	if(tr.index() != 0){
			    $.ajax({
	       			type:"post",
	       			url:"/index.php/admin/dishes/moveup1",
	      			data:{"sort":sort,"food_category_id":food_category_id},
	        		success:function(data){
	        		 	 $('#mytype').html(data);
	        		},
	        		error:function(){
	        			alert("出错了");
	        		}
	       	}); 
		} 
	}
	
	//菜品分类数据下移
	function movedown1(obj){
		var len = parseInt(($("#mytype").find('tr').length)-1); 
		//console.log(len);
		var sort = $(obj).data('sort');
		//console.log(sort);
		var food_category_id = $(obj).data('food_category_id');
		//console.log(food_category_id);
	  	var tr = $(obj).parents("tr");
	  	//console.log(tr.index());
			if (tr.index() != len){ 
			    $.ajax({
		   			type:"post",
		   			url:"/index.php/admin/dishes/movedown1",
		  			data:{"sort":sort,"food_category_id":food_category_id},
		    		success:function(data){
		    		 	$('#mytype').html(data);
		    		},
		    		error:function(){
		    			alert("出错了");
		    		}
		   	}); 
       	}
	 }

	
	
/*	function movedown(obj){ 
    	var len = $(".movedown").length; 
	    var $tr = $(obj).parents("tr"); 
    	if ($tr.index() != len) { 
     	 $tr.fadeOut().fadeIn(); 
      	$tr.next().after($tr); 
    	} 
 }  */
	
	//菜品数据上移(food表)
	function moveup(obj){
		var sort = $(obj).data('sort');			//排序ID
		var food_id = $(obj).data('food_id');	//菜品自增ID
		var page = $(".current").data('page');	//当前页数
		if(page == undefined){
			page = 1;
		}
		var when_tr = parseInt($(obj).parent().prev().text());
		
		if(page==1 && when_tr==1){
			return false;
		}
		$.ajax({
   			 type:"post",
   			 url:"/index.php/admin/dishes/moveup",
  			 data:{"sort":sort,"food_id":food_id},
  			 dataType:"json",
    		 success:function(data){
    		 	if(data.code == 1){
			    	$.ajax({
						url:"/index.php/admin/Dishes/deskInfo/page/"+page,
						type:"get",
						success:function(data){
							$("#all").html(data);
						},
						error:function(){
							alert("出错了");
						}
					});	
    		 	}
    		}
		}); 
	} 
	
	//菜品数据下移(food表)
	function movedown(obj){
		var sort = $(obj).data('sort');
		var food_id = $(obj).data('food_id');
		var page = parseInt($(".current").html());
		var pageArr = new Array();
		$(".pagination").children().children('a').each(function(index,element){
			var when_page = parseInt($(element).data('page'));		
			pageArr[index]= when_page;
		});
		var max=pageArr[0]
		for(var i=1;i<pageArr.length;i++){
		  if(pageArr[i]>max){
		    max=pageArr[i];														//获取最大页数
		  }
		}
		var last_tr = $("#mytr").children().children('tr:last');				//获取最后一个tr
		var downObj = $(obj).parent();											//获取点击时的tr
		if(page == max && last_tr == downObj){									//如果当前页是最后一页且所点击的tr是最后一个tr，则中止操作
			return false;
		}
	    $.ajax({
   			 type:"post",
   			 url:"/index.php/admin/dishes/movedown",
  			 data:{"sort":sort,"food_id":food_id},
  			 dataType:"json",
    		 success:function(data){
    		 	if(data.code == 1){
			    	$.ajax({
						url:"/index.php/admin/Dishes/deskInfo/page/"+page,
						type:"get",
						success:function(data){
							$("#all").html(data);
						},
						error:function(){
							alert("出错了");
						}
					});	
    		 	}
    		}
   		}); 
	}

	//点击菜品类表显示对应菜品信息		
	function showinfo(obj){
	    var food_category_id = $(obj).data("id");
		$.ajax({
	        type:"get",
	        url:"/index.php/admin/dishes/showDisinfoBykey/food_category_id/"+food_category_id+"",
	        success:function (data){
	            $('#all').html(data);
	        }
	    });
	}

	//提交菜品分类模态框
	function commit(){
	    if($("#way").val() != 1){
	        if($("#food_category_name").val() == ""){
	            alert("菜品分类不能为空");
	        }else{
	        	var food_category_name = $("#food_category_name").val();
	            var formdata=new FormData();
	            formdata.append("food_category_name",food_category_name);           
	            formdata.append("is_timing",$("input[name='is_timing']:checked").val());
	            
	            // if ($("#commitfile").val() != ""){
	            //     var reader = new FileReader();
	            //     reader.readAsDataURL($('#commitfile')[0].files[0]);
	            //     formdata.append("file",$('#commitfile')[0].files[0]);
	            // }
	            if($("input[name='is_timing']:checked").val() == 1){
	                var timeInfo = $("#time").children();
	                var dayInfo = $("#day").children();
	                var dayInfoArray = new Array();
	                $.each(dayInfo,function(k,v){
	                    dayInfoArray[k] = new Array();
	                    var i = 0;
	                    $.each($(v).children(),function(k1,v1){
	                        var length = $(v).children().length;
	                        if($(v1)[0].checked == true || k1 == (length-2) || k1 == (length-1)){
	                            dayInfoArray[k][i] = $(v1).val();
	                            i++;
	                        }
	                    });
	                });
	
	                var timeInfoArray = new Array();
	                $.each(timeInfo,function(k3,v3){
	                    timeInfoArray[k3] = new Array();
	                    var j = 0;
	                    $.each($(v3).children(),function(k4,v4){
	                        if($(v4).val() != "") {
	                            timeInfoArray[k3][j] = $(v4).val();
	                            j++;
	                        }
	                    });
	                });
	               /* console.log(timeInfoArray);
	                console.log(dayInfoArray);*/
	                timeInfoArray = JSON.stringify(timeInfoArray);
	                dayInfoArray = JSON.stringify(dayInfoArray);
	                console.log(timeInfoArray);
	                console.log(dayInfoArray);
	                formdata.append("time",timeInfoArray);
	                formdata.append("day",dayInfoArray)
	            }
	            $.ajax({
	                type : 'post',
	                url : '/index.php/admin/Dishes/createDishetype',
	                data:formdata,
	                // dataType:"json",
	                cache : false,
	                processData : false, // 不处理发送的数据，因为data值是Formdata对象，不需要对数据做处理
	                contentType : false, // 不设置Content-type请求头
	                success : function(data){
	                    $('#mytype').html(data);
	                   // alert("新增成功！");
	                    $("input[type='reset']").trigger("click");
	                }
	            });
	        }
	    }else{
	      //alert("编辑");
	    
	        var formdata=new FormData();
	        formdata.append("restaurant_id",$("#restaurant_id").val());
	        formdata.append("food_category_id",$("#food_category_id").val());
	        formdata.append("food_category_name",$("#food_category_name").val());
	        formdata.append("is_timing",$("input[name='is_timing']:checked").val());
	       
	        // if ($("#commitfile").val() != ""){
	        //     var reader = new FileReader();
	        //     reader.readAsDataURL($('#commitfile')[0].files[0]);
	        //     formdata.append("file",$('#commitfile')[0].files[0]);
	        // }
	
	        if($("input[name='is_timing']:checked").val() == 1){
	            var timeInfo = $("#time").children();
	            var dayInfo = $("#day").children();
	            var dayInfoArray = new Array();
	            $.each(dayInfo,function(k,v){
	                dayInfoArray[k] = new Array();
	                var i = 0;
	                $.each($(v).children(),function(k1,v1){
	                    var length = $(v).children().length;
	                    if($(v1)[0].checked == true || k1 == (length-2) || k1 == (length-1)) {
	                        dayInfoArray[k][i] = $(v1).val();
	                        i++;
	                    }
	                });
	            });
	
	            var timeInfoArray = new Array();
	            $.each(timeInfo,function(k3,v3){
	                timeInfoArray[k3] = new Array();
	                var j = 0;
	                $.each($(v3).children(),function(k4,v4){
	                    if($(v4).val() != "") {
	                        timeInfoArray[k3][j] = $(v4).val();
	                        j++;
	                    }
	                });
	            });
	            timeInfoArray = JSON.stringify(timeInfoArray);
	            dayInfoArray = JSON.stringify(dayInfoArray);
	            formdata.append("time",timeInfoArray);
	            formdata.append("day",dayInfoArray)
	        }
	
	       $.ajax({
	            type : 'post',
	            url : '/index.php/admin/Dishes/modifyDishestype',
	            data:formdata,
	            // dataType:"json",
	            cache : false,
	            processData : false, // 不处理发送的数据，因为data值是Formdata对象，不需要对数据做处理
	            contentType : false, // 不设置Content-type请求头
	            success : function(data){
	                console.log(data);
	                $('#mytype').html(data);
	                //alert("编辑成功！");
	                //$("input[type='reset']").trigger("click");
	            }
	        });
	
	    }
	}

	//模态框消失后清空表单
	$('#addSort').on('hidden.bs.modal', function (){
	    // 执行一些动作...
	    $('#food_category_name').attr("value","");
	    $('#edit_upload_box').attr("src","");
	    $("input[type='reset']").trigger("click");
	    $("#time").html("");
	    $("#day").html("");
	    $("#show2").hide();
	})
	
	//删除时间
	function deletetime(){
	    $('.dingtime').each(function(index,element){
	        $(element).remove((index));});
	}

/*
 ===========================================================================================================
 */
function trigger(){
    triggerTime();
    triggerDay();
}

function triggerTime(){
    $('.startTime').datetimepicker({
        format: 'yyyy-mm-dd hh:ii:00',
        language: 'zh-CN',
        pickDate: true,
        pickTime: true,
        autocolse:true,
        hourStep: 1,
        minuteStep: 15,
        secondStep: 30,
        inputMask: true
    }).on("click",function(ev){
        $(".startTime").datetimepicker("setEndDate", $(".endTime").val());
    });
    $('.endTime').datetimepicker({
        format: 'yyyy-mm-dd hh:ii:00',
        language: 'zh-CN',
        autocolse:true,
        pickDate: true,
        pickTime: true,
        hourStep: 1,
        minuteStep: 15,
        secondStep: 30,
        inputMask: true
    }).on("click", function (ev) {
        $(".endTime").datetimepicker("setStartDate", $(".startTime").val());
    });
}

	function triggerDay(){
	    for(var i=0;i<24;i++){
	        if(i<10){
	            $("#day").children(":last").find("select").append("<option value='0"+i+":00'>0"+i+":00</option>");  //添加一项option
	            $("#day").children(":last").find("select").append("<option value='0"+i+":30'>0"+i+":30</option>");  //添加一项option
	        }else{
	            $("#day").children(":last").find("select").append("<option value='"+i+":00'>"+i+":00</option>");  //添加一项option
	            $("#day").children(":last").find("select").append("<option value='"+i+":30'>"+i+":30</option>");  //添加一项option
	        }
	    }
	}

	function changeType(type){
	    $("#add-btn").data("type",type);
	}

	//添加时间段
	function addTiming(obj){
	    var type = $(obj).data("type");
	    if(type){
	        var str = '<div style="margin-top: 5px"> <label for="startTime">开始时间：</label><input type="text" class="startTime" id="startTime" name="startTime"> <label for="endTime">结束时间：</label><input type="text" name="endTime" class="endTime" id="endTime"> </div>';
	        $("#time").append(str);
	    }else{
	        var str = '<div style="margin-top: 5px"> <input type="checkbox" name="monday" value="1"><label >星期一</label>'
	            +'<input type="checkbox" name="tuesday" value="2"><label>星期二</label>'
	            +'<input type="checkbox" name="wednesday" value="3"><label>星期三</label>'
	            +'<input type="checkbox" name="thursday" value="4"><label >星期四</label>'
	            +'<input type="checkbox" name="friday" value="5"><label>星期五</label>'
	            +'<input type="checkbox" name="saturday" value="6"><label >星期六</label>'
	            +'<input type="checkbox" name="sunday" value="0"><label >星期日</label>'
	            +'<select name="dayStartTime" id="">' +
	            '</select> 至' +
	            ' <select name="dayEndTime" id="">'+
	            '</select>';
	        $("#day").append(str);
	    }
	    trigger();
	}

	//点击页码执行动作
	$("#detail-page").children().children("a").click(function(){
		var page = parseInt($(this).data("page"));
		console.log(page);
		$.ajax({
			url:"/index.php/admin/Dishes/deskInfo/page/"+page+"",
			type:"get",
			success:function(data){
				$("#all").html(data);
			},
			error:function(){
				alert("出错了");
			}
		});
	});
	

	
	//点菜品编辑跳到指定编辑页且传递一个当前页数
	function modify_food(obj){
		var food_id = $(obj).data('food_id');
		var food_category_id = $(obj).data('food_category_id');
		var page = $('.current').data('page');
		console.log(food_category_id);
		if(food_category_id == undefined){
			food_category_id = 0;
		}
		location.href = "/index.php/admin/Dishes/edit/food_id/"+food_id+"/food_category_id/"+food_category_id+"/page/"+page;
	}
	
		
	
	
	
	//新增菜品分类模态框
	function show_addSort(){
		$("#addSort").modal('show');
		$('#way').val(0);
	}
