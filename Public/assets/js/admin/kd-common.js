/*!
 * Author：liutj
 * Copyright 2011-2015 Kuaidian, Inc.
 * 
 */
$(function () {
      searchMyme(0);
      pageInit();
      $("#btnSearch").on("click", function () {
        searchMyme(0);
        pageInit();
        return false;
      });
});

function searchMyme(page, pageination) {
      var month = $("#btnMonth").val();
      var obj = {
        Month: month,
        OpType: "getme",
        page: (page + 1)
        , rows: 10
      };
      var url = "__MODULE__/Appliance/index";
      $.get(url, obj, function (data) {
        $("#tbIncome").empty();
        var obj = JSON.parse(data);
        var total = obj.Total;
        $("#hideTotalCount").val(total);
        var arrHtml = [];
        $.each(obj.Rows, function (i, data) {
          arrHtml.push("<tr><td>" + (i + 1) + "</td>");
          arrHtml.push("<td>" + data.Account + "</td>");
          arrHtml.push("<td>" + data.Name + "</td>");
          arrHtml.push("<td>" + data.Month + "</td>");
          arrHtml.push("<td>" + data.IncomeAmount + "</td>");
          arrHtml.push("<td><a href='MyDetail.aspx?Account="+data.Account+"&Month="+data.Month+"' class='a-blue'>查看明细</a></td></tr>");
        });
        $("#tbIncome").append(arrHtml.join(''));
      });
    };
    function pageInit() {
      var totalCount = $("#hideTotalCount").val();
      $("#Pagination").pagination(parseInt(totalCount), {
        items_per_page: 10,
        //current_page: 1,//当前选中的页面默认是0，表示第1页
        num_edge_entries: 2,//两侧显示的首尾分页的条目数,默认为0，好像是尾部显示的个数
        num_display_entries: 2,//连续分页主体部分显示的分页条目数,默认是10
        link_to: "javascript:void(0)",//分页的链接
        prev_text: "上一页",
        next_text: "下一页",
        prev_show_always: true,
        next_show_always: true,
        callback: searchMyIncome
      });
    }
//请求数据 
	function InitTable(pageIndex) { 
		$.post(
			"__MODULE__/Appliance/index",
			{
				"page":pageIndex,
				"limit":pageSize
			}, 
			function(data){ 
				$("#Table-Result tr:gt(0)").remove(); //移除Id为Result的表格里的行，从第二行开始（这里根据页面布局不同页变） 
				$("#Table-Result").append(data); //将返回的数据追加到表格 
			});
		}
}); 