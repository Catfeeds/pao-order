$(window).ready(function(){
	/* ---------------------------------------------- /*
	 * 左侧折叠菜单
	/* ---------------------------------------------- */
	$('.treeview-header').click(function(){
		//为当前选中选项添加选中样式
		$('.sidebar-menu').find('.active').removeClass('active');
		$(this).addClass('active');

		// //为当前选中选项切换折叠按钮
		$(this).parent().siblings().find('.pull-right-container').removeClass('minus-icon');
		//为当前选中选项伸缩菜单
		$(this).siblings().slideToggle(500,function(e){
			var state=$(this).css('display');
			if(state=='block'){
				$(this).siblings().find('.pull-right-container').addClass('minus-icon');
			}else{
				$(this).siblings().find('.pull-right-container').removeClass('minus-icon');
			}		
		});
		$(this).parent().siblings().find('.treeview-menu').slideUp();		
	});

	$('.treeview-menu li a').click(function(){
		
		$('.treeview-menu').find('a').removeClass('active');
		$(this).addClass('active');
	});
	$('.dishes-sale-item button').click(function(event) {
		$(this).parents('.sale-item-head').siblings('.dishes-sale-info').slideToggle();
	});
});
