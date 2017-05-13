	//横屏广告的预览+上传(预览时就上传)
	function preview1(file){						
		var prevDiv = $(file).parents('.showimg').find('.ad-imgBox')[0];			//获取上传图片父级所在的DOM对象
		var statu = $(file).parents('.showimg').find('.ad-imgBox').children(':first').attr('src');//获取广告位状态（空或已有广告）
		var aid =$(file).parents('.showimg').find('.ad-imgBox').attr('id');			//当前广告ID
		var wtype =$(file).attr('name');//广告位类型(默认或动态广告位)
		//------------------------------------广告位的广告预览-----------------------------------------
		if(file.files && file.files[0]){
			var reader = new FileReader();
			reader.onload = function(evt){
				prevDiv.innerHTML = '<img src="' + evt.target.result + '" class="pre100 center-block" />';
			}
			reader.readAsDataURL(file.files[0]);
		}else{
			prevDiv.innerHTML = '<div class="img" style="filter:progid:DXImageTransform.Microsoft.AlphaImageLoader(sizingMethod=scale,src=\'' + file.value + '\'"></div>';
		}
		//------------------------------------广告位上传广告--------------------------------------------
	  	var formdata=new FormData(); 
		formdata.append("file" , file.files[0]);			//上传文件
		formdata.append("wtype",wtype);						//广告位类型，第一个广告位是默认，第二个广告位是可变
		formdata.append("aid",aid)							//广告id
		formdata.append("statu",statu);						//广告图片src值
		$.ajax({
           	type : 'post',
           	url : '/index.php/admin/Moudle/uploadimg',
           	data : formdata,
           	cache : false,
           	processData : false, // 不处理发送的数据，因为data值是Formdata对象，不需要对数据做处理
           	contentType : false, // 不设置Content-type请求头
           	success : function(data){
           	alert("上传成功！");
           	$('#mytr').html(data);
           }   
	    });			  
	}
	
	//竖屏广告的预览+上传(预览时就上传)
   	function preview(file){
   		var prevDiv = $(file).parents('.showimg1').find('.ad-imgBox')[0];
   		var statu = $(file).parents('.showimg1').find('.ad-imgBox').children(':first').attr('src');
   		var aid = $(file).parents('.showimg1').find('.ad-imgBox').attr('id');
   		var wtype =$(file).attr('name');
		if(file.files && file.files[0]){
			var reader = new FileReader();
			reader.onload = function(evt){
				prevDiv.innerHTML = '<img src="' + evt.target.result + '" class="pre100 center-block" />';
			}
			reader.readAsDataURL(file.files[0]);
		}else{
			prevDiv.innerHTML = '<div class="img" style="filter:progid:DXImageTransform.Microsoft.AlphaImageLoader(sizingMethod=scale,src=\'' + file.value + '\'"></div>';
		}			  
	  	var formdata=new FormData(); 	
		formdata.append("file" , file.files[0]);			//上传文件
		formdata.append("wtype",wtype);						//广告位类型，第一个广告位是默认，第二个广告位是可变
		formdata.append("aid",aid)							//广告id
		formdata.append("statu",statu);						//广告图片src值
		$.ajax({
           	type : 'post',
          	url : '/index.php/admin/Moudle/uploadphimg',
           	data : formdata,
           	cache : false,
           	processData : false, // 不处理发送的数据，因为data值是Formdata对象，不需要对数据做处理
           	contentType : false, // 不设置Content-type请求头
           	success : function(data){
	           	alert("上传成功！");
	    		$("#mytr1").html(data);
           	}   
	    });	
   	}
	
	//叫号屏广告上传
   	function preview2(file){
   		var prevDiv = $(file).parents('.showimg1').find('.ad-imgBox')[0];
   		var aid = $(file).attr('id');
		if(file.files && file.files[0]){
			var reader = new FileReader();
			reader.onload = function(evt){
				prevDiv.innerHTML = '<img src="' + evt.target.result + '" class="pre100 center-block" />';
			}
		reader.readAsDataURL(file.files[0]);
		}else{
			 prevDiv.innerHTML = '<div class="img" style="filter:progid:DXImageTransform.Microsoft.AlphaImageLoader(sizingMethod=scale,src=\'' + file.value + '\'"></div>';
		}		  
	  	var formdata=new FormData(); 
		formdata.append("file" , file.files[0]);//上传文件	
		formdata.append("aid",aid)//广告id
		$.ajax({
           	type : 'post',
           	url : '/index.php/admin/Moudle/uploadsnimg',
           	data : formdata,
           	dataType:"json",
           	cache : false,
           	processData : false, // 不处理发送的数据，因为data值是Formdata对象，不需要对数据做处理
           	contentType : false, // 不设置Content-type请求头
           	success : function(data){
	           	alert(data.msg);		
           }   
	    });	
   	}
	
	//删除横屏广告
	function deladver(z){
   		var msg = "确定要删除一条广告吗？"
   		if(confirm(msg) == true){
   			$.ajax({
   				type:"post",
   				url:"/index.php/admin/Moudle/deladver",
   				data:{"advertisement_id":z},
   				success:function(data){
				 	$("#mytr").html(data);
   				}
   			});
   		}
   	}
	 	
	//删除竖屏广告
   	function deladver1(z){
   		var msg = "确定要删除一条广告吗？"
   		if(confirm(msg) == true){
   			$.ajax({
   				type:"post",
   				url:"/index.php/admin/Moudle/deladver1",
   				data:{"advertisement_id":z},
   				success:function(data){
   					$("#mytr1").html(data);
   				}
   			});
   		}
   	}
 
   	//改变流程页开启或关闭状态
	function changestatu(statu,i){
		$.ajax({
			type:"get",
			url:"/index.php/admin/Moudle/modifyprocess",
			data:{"id":i,"status":$(statu).val()},
			dataType:"json",
			success:function(data){
				alert("状态已改变！")
			}
		});
	}
	
	//每张广告的间隔时间
	function changetime(){
		var time  = document.getElementById('interval').value;
		$.ajax({
			type:"post",
			url:"/index.php/admin/moudle/timeSettings",
			data:{"advertise_time":time},
			dataType:"json",
			success:function(data){
				alert("修改成功，当前广告间隔时间为:"+data[0]['advertise_time']+"秒");
			}
		});
	}

	//改变默认广告语
	function changeadvlang(){
		var value = $("input[name='advlang']").val();
			$.ajax({
				type:"post",
				url:"/index.php/admin/moudle/adv_langSet",
				data:{"adv_language":value},
				dataType:"json",
				success:function(data){
					alert("修改成功，当前广告语:"+data['adv_language']);
				}
			});
	}
	
	