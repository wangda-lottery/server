(window.webpackJsonp=window.webpackJsonp||[]).push([["chunk-c1ab"],{"3TsE":function(t,e,a){},"6uf2":function(t,e,a){"use strict";var i=a("3TsE");a.n(i).a},CkRK:function(t,e,a){"use strict";a.r(e);var i=a("14Xm"),n=a.n(i),s=a("D3Ub"),l=a.n(s),r=a("QbLZ"),o=a.n(r),c=a("EwjG"),u=a("L2JU"),d={name:"PlatParams",filters:{},data:function(){return{listLoading:!1,paramNameFilter:void 0,editDlgVisible:!1,editObject:{}}},computed:o()({},Object(u.b)(["params"])),mounted:function(){var t=this;return l()(n.a.mark(function e(){return n.a.wrap(function(e){for(;;)switch(e.prev=e.next){case 0:t.getParamList();case 1:case"end":return e.stop()}},e,t)}))()},methods:{getParamList:function(){var t=this;return l()(n.a.mark(function e(){return n.a.wrap(function(e){for(;;)switch(e.prev=e.next){case 0:return t.listLoading=!0,e.prev=1,e.next=4,t.$store.dispatch(c.f.GetPlatParamList,{});case 4:e.next=9;break;case 6:e.prev=6,e.t0=e.catch(1),t.$message.error(e.t0.message);case 9:t.listLoading=!1;case 10:case"end":return e.stop()}},e,t,[[1,6]])}))()},onEditParam:function(t){this.editObject=t,this.editDlgVisible=!0},onSaveValue:function(){var t=this;return l()(n.a.mark(function e(){return n.a.wrap(function(e){for(;;)switch(e.prev=e.next){case 0:return t.listLoading=!0,e.prev=1,e.next=4,t.$store.dispatch(c.f.UpdatePlatParams,t.editObject);case 4:t.editDlgVisible=!1,t.$message.success("修改成功"),e.next=11;break;case 8:e.prev=8,e.t0=e.catch(1),t.$message.error(e.t0.message);case 11:t.getParamList(),t.listLoading=!1;case 13:case"end":return e.stop()}},e,t,[[1,8]])}))()}}},p=(a("6uf2"),a("KHd+")),f=Object(p.a)(d,function(){var t=this,e=t.$createElement,a=t._self._c||e;return a("div",{directives:[{name:"loading",rawName:"v-loading",value:t.listLoading,expression:"listLoading"}],staticClass:"app-container"},[a("div",{staticClass:"filter-container"},[a("el-input",{staticClass:"filter-item",staticStyle:{width:"240px"},attrs:{clearable:"",placeholder:"输入参数名称过滤",icon:"el-icon-circle-plus"},model:{value:t.paramNameFilter,callback:function(e){t.paramNameFilter=e},expression:"paramNameFilter"}}),t._v(" "),a("el-button",{staticClass:"filter-item",attrs:{type:"success",icon:"el-icon-search"},on:{click:t.getParamList}},[t._v("查询")])],1),t._v(" "),a("el-table",{directives:[{name:"loading",rawName:"v-loading",value:t.listLoading,expression:"listLoading"}],attrs:{data:t.params,border:"",fit:"",stripe:"","highlight-current-row":""}},[a("el-table-column",{attrs:{label:"参数名称",align:"center",width:"200px","show-overflow-tooltip":""},scopedSlots:t._u([{key:"default",fn:function(e){return[a("el-button",{attrs:{type:"text"},on:{click:function(a){t.onEditParam(e.row)}}},[t._v(t._s(e.row.title))])]}}])}),t._v(" "),a("el-table-column",{attrs:{label:"参数值",align:"left","show-overflow-tooltip":""},scopedSlots:t._u([{key:"default",fn:function(e){return[a("el-button",{attrs:{type:"text"},on:{click:function(a){t.copyData(e.row.value)}}},[t._v(t._s(e.row.value))])]}}])}),t._v(" "),a("el-table-column",{attrs:{label:"参数单位",align:"center",width:"100"},scopedSlots:t._u([{key:"default",fn:function(e){return[a("span",[t._v(t._s(e.row.unit||"--"))])]}}])}),t._v(" "),a("el-table-column",{attrs:{label:"说明","show-overflow-tooltip":""},scopedSlots:t._u([{key:"default",fn:function(e){return[a("span",[t._v(t._s(e.row.tips))])]}}])})],1),t._v(" "),a("el-dialog",{attrs:{title:"参数编辑",visible:t.editDlgVisible,width:"500px"},on:{"update:visible":function(e){t.editDlgVisible=e}}},[a("el-form",{attrs:{model:t.editObject,"label-width":"90px"}},[a("el-form-item",{attrs:{label:"参数名"}},[a("el-input",{attrs:{type:"text",readonly:""},model:{value:t.editObject.title,callback:function(e){t.$set(t.editObject,"title",e)},expression:"editObject.title"}})],1),t._v(" "),a("el-form-item",{attrs:{label:"参数值"}},[a("el-input",{attrs:{type:"textarea",rows:"5"},model:{value:t.editObject.value,callback:function(e){t.$set(t.editObject,"value",e)},expression:"editObject.value"}})],1)],1),t._v(" "),a("div",{staticClass:"dialog-footer",attrs:{slot:"footer"},slot:"footer"},[a("el-button",{on:{click:function(e){t.editDlgVisible=!1}}},[t._v(" 关 闭")]),t._v(" "),a("el-button",{attrs:{type:"primary"},on:{click:t.onSaveValue}},[t._v("保 存")])],1)],1)],1)},[],!1,null,null,null);f.options.__file="params.vue";e.default=f.exports}}]);