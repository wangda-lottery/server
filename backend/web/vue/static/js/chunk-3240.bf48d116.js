(window.webpackJsonp=window.webpackJsonp||[]).push([["chunk-3240"],{"+ZcP":function(t,e,a){"use strict";a.r(e);var i=a("14Xm"),s=a.n(i),n=a("D3Ub"),r=a.n(n),o=a("QbLZ"),c=a.n(o),l=a("L2JU"),d=a("7BsA"),h={components:{CountTo:a.n(d).a},data:function(){return{}},computed:c()({},Object(l.b)(["reports"])),methods:{},mounted:function(){}},u=(a("/sw9"),a("KHd+")),p=Object(u.a)(h,function(){var t=this,e=t.$createElement,a=t._self._c||e;return a("el-row",{staticClass:"panel-group",attrs:{gutter:6}},[a("el-col",{staticClass:"card-panel-col",attrs:{xs:24,sm:12,lg:6}},[a("div",{staticClass:"card-panel"},[a("div",{staticClass:"card-panel-icon-wrapper icon-money-today"},[a("svg-icon",{attrs:{"icon-class":"deal","class-name":"card-panel-icon"}})],1),t._v(" "),a("div",{staticClass:"card-panel-description"},[a("div",{staticClass:"card-panel-text"},[t._v("\n          昨日充值\n        ")]),t._v(" "),a("count-to",{staticClass:"card-panel-num",attrs:{"start-val":0,"end-val":t.reports.totalTopUpCountYesterday,duration:800}})],1)])]),t._v(" "),a("el-col",{staticClass:"card-panel-col",attrs:{xs:24,sm:12,lg:6}},[a("div",{staticClass:"card-panel"},[a("div",{staticClass:"card-panel-icon-wrapper icon-shopping"},[a("svg-icon",{attrs:{"icon-class":"peoples","class-name":"card-panel-icon"}})],1),t._v(" "),a("div",{staticClass:"card-panel-description"},[a("div",{staticClass:"card-panel-text"},[t._v("今日抽奖人次数")]),t._v(" "),a("count-to",{staticClass:"card-panel-num",attrs:{"start-val":0,"end-val":t.reports.drawCountToday,duration:800}})],1)])]),t._v(" "),a("el-col",{staticClass:"card-panel-col",attrs:{xs:24,sm:12,lg:6}},[a("div",{staticClass:"card-panel"},[a("div",{staticClass:"card-panel-icon-wrapper icon-wechat"},[a("svg-icon",{attrs:{"icon-class":"transaction","class-name":"card-panel-icon"}})],1),t._v(" "),a("div",{staticClass:"card-panel-description"},[a("div",{staticClass:"card-panel-text"},[t._v("今日红包总额")]),t._v(" "),a("count-to",{staticClass:"card-panel-num",attrs:{"start-val":0,"end-val":t.reports.drawExportedAmountToday/100,duration:800}})],1)])]),t._v(" "),a("el-col",{staticClass:"card-panel-col",attrs:{xs:24,sm:12,lg:6}},[a("div",{staticClass:"card-panel"},[a("div",{staticClass:"card-panel-icon-wrapper icon-money-total"},[a("svg-icon",{attrs:{"icon-class":"total","class-name":"card-panel-icon"}})],1),t._v(" "),a("div",{staticClass:"card-panel-description"},[a("div",{staticClass:"card-panel-text"},[t._v("累计红包总额")]),t._v(" "),a("count-to",{staticClass:"card-panel-num",attrs:{"start-val":0,"end-val":t.reports.drawExportedAmountTotal/100,duration:800}})],1)])])],1)},[],!1,null,"7b55f380",null);p.options.__file="PanelGroup.vue";var m=p.exports,f=a("GQeE"),v=a.n(f),g=a("MT78"),_=a.n(g),y=a("7Qib"),w={props:{className:{type:String,default:"chart"},width:{type:String,default:"100%"},height:{type:String,default:"350px"},autoResize:{type:Boolean,default:!0},chartData:{type:Object,required:!0}},data:function(){return{chart:null}},watch:{chartData:{deep:!0,handler:function(){this.generateChartOptions(this.chartData)}}},mounted:function(){var t=this;this.chart=_.a.init(this.$el,"macarons"),this.generateChartOptions(this.chartData),this.autoResize&&(this.__resizeHandler=Object(y.b)(function(){t.chart&&t.chart.resize()},100),window.addEventListener("resize",this.__resizeHandler)),document.getElementsByClassName("sidebar-container")[0].addEventListener("transitionend",this.sidebarResizeHandler)},beforeDestroy:function(){this.chart&&(this.autoResize&&window.removeEventListener("resize",this.__resizeHandler),document.getElementsByClassName("sidebar-container")[0].removeEventListener("transitionend",this.sidebarResizeHandler),this.chart.dispose(),this.chart=null)},methods:{sidebarResizeHandler:function(t){"width"===t.propertyName&&this.__resizeHandler()},generateChartOptions:function(t){var e=this;if(t){var a=v()(t);if(0!==a.length&&!t[0===a[0].length]){var i={xAxis:{data:this.generateRecentDaysAxis(t[a[0]].length),boundaryGap:!1,axisTick:{show:!1}},grid:{left:0,right:0,bottom:20,top:30,containLabel:!0},title:{text:"通道近30日流水",x:"left",y:"top"},tooltip:{trigger:"axis",axisPointer:{type:"cross"},padding:[5,10]},yAxis:{axisTick:{show:!1}},legend:{data:a},series:[]};a.forEach(function(a){i.series.push({name:a,smooth:!0,type:"line",itemStyle:{normal:{color:e.randomColor(),lineStyle:{color:e.randomColor(),width:2}}},data:t[a].map(function(t){return(t.value/100).toFixed(2)}),animationDuration:1500,animationEasing:"quadraticOut"})}),this.chart.setOption(i)}}},generateRecentDaysAxis:function(t){for(var e=new Date,a=0,i=[];a<t;)i.push(e.getMonth()+1+"/"+e.getDate()),e=new Date(e-864e5),a++;return i.reverse()},randomColor:function(){for(var t="#",e=0;e<6;e++)t+="0123456789ABCDEF"[Math.floor(16*Math.random())];return t}}},b=Object(u.a)(w,function(){var t=this.$createElement;return(this._self._c||t)("div",{class:this.className,style:{height:this.height,width:this.width}})},[],!1,null,null,null);b.options.__file="CashFlowLineChart.vue";var x=b.exports,C={props:{className:{type:String,default:"chart"},width:{type:String,default:"100%"},height:{type:String,default:"350px"},autoResize:{type:Boolean,default:!0},chartData:{type:Array,required:!0}},data:function(){return{chart:null}},watch:{chartData:{deep:!0,handler:function(t){this.generateChartOptions(t)}}},mounted:function(){var t=this;this.chart=_.a.init(this.$el,"macarons"),this.generateChartOptions(this.chartData),this.autoResize&&(this.__resizeHandler=Object(y.b)(function(){t.chart&&t.chart.resize()},100),window.addEventListener("resize",this.__resizeHandler)),document.getElementsByClassName("sidebar-container")[0].addEventListener("transitionend",this.sidebarResizeHandler)},beforeDestroy:function(){this.chart&&(this.autoResize&&window.removeEventListener("resize",this.__resizeHandler),document.getElementsByClassName("sidebar-container")[0].removeEventListener("transitionend",this.sidebarResizeHandler),this.chart.dispose(),this.chart=null)},methods:{sidebarResizeHandler:function(t){"width"===t.propertyName&&this.__resizeHandler()},generateChartOptions:function(t){this.chart.setOption({xAxis:{data:t.map(function(t){return t.label}),boundaryGap:!1,axisTick:{show:!1}},grid:{left:0,right:0,bottom:20,top:30,containLabel:!0},title:{text:"72小时成交率趋势",x:"left",y:"top"},tooltip:{trigger:"axis",axisPointer:{type:"cross"},padding:[5,10]},yAxis:{axisTick:{show:!1}},legend:{data:["成交率趋势"]},series:[{name:"成交率趋势",smooth:!0,type:"line",itemStyle:{normal:{color:"#f34500",lineStyle:{color:"#f34500",width:2}}},data:t.map(function(t){return(100*t.value).toFixed(2)}),animationDuration:1500,animationEasing:"quadraticOut"}]})}}},z=Object(u.a)(C,function(){var t=this.$createElement;return(this._self._c||t)("div",{class:this.className,style:{height:this.height,width:this.width}})},[],!1,null,null,null);z.options.__file="RatioTrendLineChart.vue";var S=z.exports,D={filters:{statusFilter:function(t){return{success:"success",pending:"danger"}[t]},orderNoFilter:function(t){return t.substring(0,30)}},data:function(){return{list:null}},created:function(){this.fetchData()},methods:{fetchData:function(){}}},E=Object(u.a)(D,function(){var t=this,e=t.$createElement,a=t._self._c||e;return a("el-table",{staticStyle:{width:"100%","padding-top":"15px"},attrs:{data:t.list}},[a("el-table-column",{attrs:{label:"Order_No","min-width":"200"},scopedSlots:t._u([{key:"default",fn:function(e){return[t._v("\n      "+t._s(t._f("orderNoFilter")(e.row.order_no))+"\n    ")]}}])}),t._v(" "),a("el-table-column",{attrs:{label:"Price",width:"195",align:"center"},scopedSlots:t._u([{key:"default",fn:function(e){return[t._v("\n      ¥"+t._s(t._f("toThousandFilter")(e.row.price))+"\n    ")]}}])}),t._v(" "),a("el-table-column",{attrs:{label:"Status",width:"100",align:"center"},scopedSlots:t._u([{key:"default",fn:function(e){return[a("el-tag",{attrs:{type:t._f("statusFilter")(e.row.status)}},[t._v(" "+t._s(e.row.status))])]}}])})],1)},[],!1,null,null,null);E.options.__file="TransactionTable.vue";var O=E.exports,L={props:{className:{type:String,default:"chart"},width:{type:String,default:"100%"},height:{type:String,default:"300px"}},data:function(){return{chart:null}},mounted:function(){var t=this;this.initChart(),this.__resizeHandler=Object(y.b)(function(){t.chart&&t.chart.resize()},100),window.addEventListener("resize",this.__resizeHandler)},beforeDestroy:function(){this.chart&&(window.removeEventListener("resize",this.__resizeHandler),this.chart.dispose(),this.chart=null)},methods:{initChart:function(){this.chart=_.a.init(this.$el,"macarons"),this.chart.setOption({tooltip:{trigger:"axis",axisPointer:{type:"shadow"}},radar:{radius:"66%",center:["50%","42%"],splitNumber:8,splitArea:{areaStyle:{color:"rgba(127,95,132,.3)",opacity:1,shadowBlur:45,shadowColor:"rgba(0,0,0,.5)",shadowOffsetX:0,shadowOffsetY:15}},indicator:[{name:"代理1",max:1e4},{name:"代理2",max:2e4},{name:"代理3",max:2e4},{name:"代理4",max:2e4},{name:"代理5",max:2e4},{name:"代理6",max:2e4}]},legend:{left:"center",bottom:"10",data:["预期代理流水","实际代理流水"]},series:[{type:"radar",symbolSize:0,areaStyle:{normal:{shadowBlur:13,shadowColor:"rgba(0,0,0,.2)",shadowOffsetX:0,shadowOffsetY:10,opacity:1}},data:[{value:[5e3,7e3,12e3,11e3,15e3,14e3],name:"预期代理流水"},{value:[5500,11e3,12e3,15e3,12e3,12e3],name:"实际代理流水"}],animationDuration:3e3}]})}}},k=Object(u.a)(L,function(){var t=this.$createElement;return(this._self._c||t)("div",{class:this.className,style:{height:this.height,width:this.width}})},[],!1,null,null,null);k.options.__file="RaddarChart.vue";var N=k.exports;a("gX0l");var T={props:{className:{type:String,default:"chart"},width:{type:String,default:"100%"},height:{type:String,default:"300px"},chartData:{type:Array,required:!0}},data:function(){return{chart:null}},watch:{chartData:{deep:!0,handler:function(t){this.initChart(t)}}},mounted:function(){var t=this;this.initChart(),this.__resizeHandler=Object(y.b)(function(){t.chart&&t.chart.resize()},100),window.addEventListener("resize",this.__resizeHandler)},beforeDestroy:function(){this.chart&&(window.removeEventListener("resize",this.__resizeHandler),this.chart.dispose(),this.chart=null)},methods:{initChart:function(){this.chart=_.a.init(this.$el,"macarons"),this.chart.setOption({tooltip:{trigger:"item",formatter:"{a} <br/>{b} : {c} ({d}%)"},legend:{left:"center",bottom:"10",data:this.chartData.map(function(t){return t.name})},calculable:!0,series:[{name:"流水比例",type:"pie",roseType:"radius",radius:[15,95],center:["50%","38%"],data:this.chartData,animationEasing:"cubicInOut",animationDuration:1600}]})}}},j=Object(u.a)(T,function(){var t=this.$createElement;return(this._self._c||t)("div",{class:this.className,style:{height:this.height,width:this.width}})},[],!1,null,null,null);j.options.__file="PieChart.vue";var H=j.exports,A={props:{className:{type:String,default:"chart"},width:{type:String,default:"100%"},height:{type:String,default:"300px"},chartData:{type:Object,required:!0}},data:function(){return{chart:null}},watch:{chartData:{deep:!0,handler:function(t){this.initChart(t)}}},mounted:function(){var t=this;this.initChart(),this.__resizeHandler=Object(y.b)(function(){t.chart&&t.chart.resize()},100),window.addEventListener("resize",this.__resizeHandler)},beforeDestroy:function(){this.chart&&(window.removeEventListener("resize",this.__resizeHandler),this.chart.dispose(),this.chart=null)},methods:{initChart:function(){this.chartData&&this.chartData["成交单数"]&&(this.chart=_.a.init(this.$el,"macarons"),this.chart.setOption({tooltip:{trigger:"axis",axisPointer:{type:"shadow"}},grid:{top:10,left:"2%",right:"2%",bottom:"3%",containLabel:!0},xAxis:[{type:"category",data:this.chartData["成交单数"].map(function(t){return t.label}),axisTick:{alignWithLabel:!0}}],yAxis:[{type:"value",axisTick:{show:!1}}],series:[{name:"成交单数",type:"bar",stack:"count",barWidth:"60%",data:this.chartData["成交单数"].map(function(t){return t.count}),animationDuration:6e3},{name:"未成交单数",type:"bar",stack:"count",barWidth:"60%",data:this.chartData["未成交单数"].map(function(t){return t.count}),animationDuration:6e3}]}))}}},R=Object(u.a)(A,function(){var t=this.$createElement;return(this._self._c||t)("div",{class:this.className,style:{height:this.height,width:this.width}})},[],!1,null,null,null);R.options.__file="BarChart.vue";var $=R.exports,B={name:"PanThumb",props:{image:{type:String,required:!0},zIndex:{type:Number,default:1},width:{type:String,default:"150px"},height:{type:String,default:"150px"}}},P=(a("CBPX"),Object(u.a)(B,function(){var t=this.$createElement,e=this._self._c||t;return e("div",{staticClass:"pan-item",style:{zIndex:this.zIndex,height:this.height,width:this.width}},[e("div",{staticClass:"pan-info"},[e("div",{staticClass:"pan-info-roles-container"},[this._t("default")],2)]),this._v(" "),e("img",{staticClass:"pan-thumb",attrs:{src:this.image}})])},[],!1,null,"4178e1ea",null));P.options.__file="index.vue";var F=P.exports,q={props:{className:{type:String,default:""},text:{type:String,default:"vue-element-admin"}}},G=(a("jAVV"),Object(u.a)(q,function(){var t=this.$createElement,e=this._self._c||t;return e("a",{staticClass:"link--mallki",class:this.className,attrs:{href:"#"}},[this._v("\n  "+this._s(this.text)+"\n  "),e("span",{attrs:{"data-letters":this.text}}),this._v(" "),e("span",{attrs:{"data-letters":this.text}})])},[],!1,null,null,null));G.options.__file="Mallki.vue";var J={components:{PanThumb:F,Mallki:G.exports},filters:{statusFilter:function(t){return{success:"success",pending:"danger"}[t]}},data:function(){return{statisticsData:{article_count:1024,pageviews_count:1024}}},computed:c()({},Object(l.b)(["name","avatar","roles"]))},M=(a("ACsc"),a("uKkk"),Object(u.a)(J,function(){var t=this,e=t.$createElement,a=t._self._c||e;return a("el-card",{staticClass:"box-card-component",staticStyle:{"margin-left":"8px"}},[a("div",{staticClass:"box-card-header",attrs:{slot:"header"},slot:"header"},[a("img",{attrs:{src:"https://wpimg.wallstcn.com/e7d23d71-cf19-4b90-a1cc-f56af8c0903d.png"}})]),t._v(" "),a("div",{staticStyle:{position:"relative"}},[a("pan-thumb",{staticClass:"panThumb",attrs:{image:t.avatar}}),t._v(" "),a("mallki",{attrs:{"class-name":"mallki-text",text:"vue-element-admin"}}),t._v(" "),a("div",{staticClass:"progress-item",staticStyle:{"padding-top":"35px"}},[a("span",[t._v("Vue")]),t._v(" "),a("el-progress",{attrs:{percentage:70}})],1),t._v(" "),a("div",{staticClass:"progress-item"},[a("span",[t._v("JavaScript")]),t._v(" "),a("el-progress",{attrs:{percentage:18}})],1),t._v(" "),a("div",{staticClass:"progress-item"},[a("span",[t._v("Css")]),t._v(" "),a("el-progress",{attrs:{percentage:12}})],1),t._v(" "),a("div",{staticClass:"progress-item"},[a("span",[t._v("ESLint")]),t._v(" "),a("el-progress",{attrs:{percentage:100,status:"success"}})],1)],1)])},[],!1,null,"747884c8",null));M.options.__file="BoxCard.vue";var V=M.exports,X=a("EwjG"),I={name:"Dashboard",components:{PanelGroup:m,CashFlowLineChart:x,RatioTrendLineChart:S,RaddarChart:N,PieChart:H,BarChart:$,TransactionTable:O,BoxCard:V},data:function(){return{todaySummaryLoading:!1,cashFlowLoading:!1,ratioTrendLoading:!1,totalSummaryLoading:!1}},computed:{},mounted:function(){var t=this;return r()(s.a.mark(function e(){return s.a.wrap(function(e){for(;;)switch(e.prev=e.next){case 0:t.getTodaySummary();case 1:case"end":return e.stop()}},e,t)}))()},methods:{getTodaySummary:function(){var t=this;return r()(s.a.mark(function e(){return s.a.wrap(function(e){for(;;)switch(e.prev=e.next){case 0:return t.todaySummaryLoading=!0,e.prev=1,e.next=4,t.$store.dispatch(X.j.GetSummary);case 4:e.next=9;break;case 6:e.prev=6,e.t0=e.catch(1),t.$message.error(e.t0.message);case 9:t.todaySummaryLoading=!1;case 10:case"end":return e.stop()}},e,t,[[1,6]])}))()}}},K=(a("dwrz"),Object(u.a)(I,function(){var t=this.$createElement,e=this._self._c||t;return e("div",{staticClass:"dashboard-editor-container"},[e("panel-group",{directives:[{name:"loading",rawName:"v-loading",value:this.todaySummaryLoading,expression:"todaySummaryLoading"}]})],1)},[],!1,null,"dccf75da",null));K.options.__file="dashboard.vue";e.default=K.exports},"/sw9":function(t,e,a){"use strict";var i=a("J1Gn");a.n(i).a},"4kVe":function(t,e,a){},ACsc:function(t,e,a){"use strict";var i=a("NMkv");a.n(i).a},ANd1:function(t,e,a){},CBPX:function(t,e,a){"use strict";var i=a("piJ4");a.n(i).a},J1Gn:function(t,e,a){},NMkv:function(t,e,a){},dwrz:function(t,e,a){"use strict";var i=a("ANd1");a.n(i).a},jAVV:function(t,e,a){"use strict";var i=a("4kVe");a.n(i).a},piJ4:function(t,e,a){},q85N:function(t,e,a){},uKkk:function(t,e,a){"use strict";var i=a("q85N");a.n(i).a}}]);