(window.webpackJsonp=window.webpackJsonp||[]).push([[7],{232:function(t,e,n){"use strict";n(230);var r=n(8),l=(n(233),{props:{id:{type:String,default:function(){return Object(r.c)(5)}},placeholder:{type:String,default:"Danh mục"},value:{default:void 0},mutiple:{type:Boolean,default:!1},onlyParent:{type:Boolean,default:!1},ignored:{type:Array,default:function(){return[]}}},computed:{categories:function(){var t=this.$store.state.blog.category.list;return this.onlyParent?t.filter((function(t){return 0==t.parent_id})):t}},mounted:function(){$("#".concat(this.id)).select2({placeholder:this.placeholder,allowClear:!0}).on("change",this.change)},methods:{isSelected:function(t){return this.mutiple?this.value.map((function(t){return parseInt(t)})).indexOf(t.id)>-1:this.value==t.id},change:function(t){this.$emit("input",t.target.value)},shouldShow:function(t){return-1==this.ignored.findIndex((function(e){return e==t.id}))}}}),c=n(3),component=Object(c.a)(l,(function(){var t=this,e=t.$createElement,n=t._self._c||e;return n("select",{staticClass:"form-control",attrs:{id:t.id,mutiple:t.mutiple},on:{change:t.change}},[n("option"),t._v(" "),t._l(t.categories,(function(e){return t.shouldShow(e)?n("option",{key:e.id,domProps:{value:e.id,selected:t.isSelected(e)}},[t._v(t._s(e.title))]):t._e()}))],2)}),[],!1,null,null,null);e.a=component.exports},234:function(t,e,n){"use strict";n(220),n(223);var r=n(8),l={props:{id:{type:String,default:function(){return Object(r.c)(5)}},loading:{type:Boolean,default:!0},numberOfLoadingRow:{type:Number,default:5}},data:function(){return{tableEl:void 0,numberOfRow:0}},computed:{bodyEl:function(){return $("tbody",this.tableEl)},headEl:function(){return $("thead",this.tableEl)},numberOfCol:function(){return this.headEl.find("th").length},htmlLoading:function(){for(var tbody="",i=1;i<=this.numberOfLoadingRow;i++){tbody+='<tr class="loading-row">';for(var t=1;t<=this.numberOfCol;t++)tbody+='<td class=""><div class="bg-placeholder p-2 cursor-pointer"></div></td>';tbody+="</tr>"}return tbody},htmlEmpty:function(){return'<tr class="empty"><td class="text-center" colspan="'.concat(this.numberOfCol,'">Không có dữ liệu</td></tr>')},isEmpty:function(){return 0==this.numberOfRow}},mounted:function(){this.tableEl=$("#".concat(this.id)),this.calcNumberOfRow(),1==this.loading&&this.createPlaceholderLoading()},updated:function(){this.calcNumberOfRow()},methods:{calcNumberOfRow:function(){this.numberOfRow=this.bodyEl.find("tr").not(".empty, .loading-row").length},createPlaceholderLoading:function(){this.bodyEl.find("tr").hide(),this.bodyEl.append(this.htmlLoading)},destroyPlaceholderLoading:function(){this.tableEl.find("tr.loading-row").remove(),this.tableEl.find("tr").show(),this.handleEmpty()},handleEmpty:function(){this.isEmpty?this.bodyEl.html(this.htmlEmpty):this.bodyEl.find("tr.empty").remove()}},watch:{loading:function(){0==this.loading?this.destroyPlaceholderLoading():this.createPlaceholderLoading()},isEmpty:function(){this.handleEmpty()}}},c=n(3),component=Object(c.a)(l,(function(){var t=this.$createElement;return(this._self._c||t)("table",{staticClass:"table text-nowrap",class:this.loading?"":"table-striped table-hover",attrs:{id:this.id}},[this._t("default")],2)}),[],!1,null,null,null);e.a=component.exports},235:function(t,e,n){"use strict";var r=n(16),l=n(17),c=n(15),o=n(8);e.a={getList:function(t){return r.a.get(Object(c.a)("api/blog/articles"),{params:t,headers:l.a.getAuthHeaders()})},create:function(data){return r.a.post(Object(c.a)("api/blog/articles"),Object(o.b)(data),{headers:l.a.getAuthHeaders()})},getDetail:function(t){return r.a.get(Object(c.a)("api/blog/articles/".concat(t)),{headers:l.a.getAuthHeaders()})},update:function(t,data){return r.a.put(Object(c.a)("api/blog/articles/".concat(t)),Object(o.b)(data),{headers:l.a.getAuthHeaders()})},delete:function(t){return r.a.delete(Object(c.a)("api/blog/articles/".concat(t)),{headers:l.a.getAuthHeaders()})}}},387:function(t,e,n){var map={"./af":244,"./af.js":244,"./ar":245,"./ar-dz":246,"./ar-dz.js":246,"./ar-kw":247,"./ar-kw.js":247,"./ar-ly":248,"./ar-ly.js":248,"./ar-ma":249,"./ar-ma.js":249,"./ar-sa":250,"./ar-sa.js":250,"./ar-tn":251,"./ar-tn.js":251,"./ar.js":245,"./az":252,"./az.js":252,"./be":253,"./be.js":253,"./bg":254,"./bg.js":254,"./bm":255,"./bm.js":255,"./bn":256,"./bn.js":256,"./bo":257,"./bo.js":257,"./br":258,"./br.js":258,"./bs":259,"./bs.js":259,"./ca":260,"./ca.js":260,"./cs":261,"./cs.js":261,"./cv":262,"./cv.js":262,"./cy":263,"./cy.js":263,"./da":264,"./da.js":264,"./de":265,"./de-at":266,"./de-at.js":266,"./de-ch":267,"./de-ch.js":267,"./de.js":265,"./dv":268,"./dv.js":268,"./el":269,"./el.js":269,"./en-SG":270,"./en-SG.js":270,"./en-au":271,"./en-au.js":271,"./en-ca":272,"./en-ca.js":272,"./en-gb":273,"./en-gb.js":273,"./en-ie":274,"./en-ie.js":274,"./en-il":275,"./en-il.js":275,"./en-nz":276,"./en-nz.js":276,"./eo":277,"./eo.js":277,"./es":278,"./es-do":279,"./es-do.js":279,"./es-us":280,"./es-us.js":280,"./es.js":278,"./et":281,"./et.js":281,"./eu":282,"./eu.js":282,"./fa":283,"./fa.js":283,"./fi":284,"./fi.js":284,"./fo":285,"./fo.js":285,"./fr":286,"./fr-ca":287,"./fr-ca.js":287,"./fr-ch":288,"./fr-ch.js":288,"./fr.js":286,"./fy":289,"./fy.js":289,"./ga":290,"./ga.js":290,"./gd":291,"./gd.js":291,"./gl":292,"./gl.js":292,"./gom-latn":293,"./gom-latn.js":293,"./gu":294,"./gu.js":294,"./he":295,"./he.js":295,"./hi":296,"./hi.js":296,"./hr":297,"./hr.js":297,"./hu":298,"./hu.js":298,"./hy-am":299,"./hy-am.js":299,"./id":300,"./id.js":300,"./is":301,"./is.js":301,"./it":302,"./it-ch":303,"./it-ch.js":303,"./it.js":302,"./ja":304,"./ja.js":304,"./jv":305,"./jv.js":305,"./ka":306,"./ka.js":306,"./kk":307,"./kk.js":307,"./km":308,"./km.js":308,"./kn":309,"./kn.js":309,"./ko":310,"./ko.js":310,"./ku":311,"./ku.js":311,"./ky":312,"./ky.js":312,"./lb":313,"./lb.js":313,"./lo":314,"./lo.js":314,"./lt":315,"./lt.js":315,"./lv":316,"./lv.js":316,"./me":317,"./me.js":317,"./mi":318,"./mi.js":318,"./mk":319,"./mk.js":319,"./ml":320,"./ml.js":320,"./mn":321,"./mn.js":321,"./mr":322,"./mr.js":322,"./ms":323,"./ms-my":324,"./ms-my.js":324,"./ms.js":323,"./mt":325,"./mt.js":325,"./my":326,"./my.js":326,"./nb":327,"./nb.js":327,"./ne":328,"./ne.js":328,"./nl":329,"./nl-be":330,"./nl-be.js":330,"./nl.js":329,"./nn":331,"./nn.js":331,"./pa-in":332,"./pa-in.js":332,"./pl":333,"./pl.js":333,"./pt":334,"./pt-br":335,"./pt-br.js":335,"./pt.js":334,"./ro":336,"./ro.js":336,"./ru":337,"./ru.js":337,"./sd":338,"./sd.js":338,"./se":339,"./se.js":339,"./si":340,"./si.js":340,"./sk":341,"./sk.js":341,"./sl":342,"./sl.js":342,"./sq":343,"./sq.js":343,"./sr":344,"./sr-cyrl":345,"./sr-cyrl.js":345,"./sr.js":344,"./ss":346,"./ss.js":346,"./sv":347,"./sv.js":347,"./sw":348,"./sw.js":348,"./ta":349,"./ta.js":349,"./te":350,"./te.js":350,"./tet":351,"./tet.js":351,"./tg":352,"./tg.js":352,"./th":353,"./th.js":353,"./tl-ph":354,"./tl-ph.js":354,"./tlh":355,"./tlh.js":355,"./tr":356,"./tr.js":356,"./tzl":357,"./tzl.js":357,"./tzm":358,"./tzm-latn":359,"./tzm-latn.js":359,"./tzm.js":358,"./ug-cn":360,"./ug-cn.js":360,"./uk":361,"./uk.js":361,"./ur":362,"./ur.js":362,"./uz":363,"./uz-latn":364,"./uz-latn.js":364,"./uz.js":363,"./vi":365,"./vi.js":365,"./x-pseudo":366,"./x-pseudo.js":366,"./yo":367,"./yo.js":367,"./zh-cn":368,"./zh-cn.js":368,"./zh-hk":369,"./zh-hk.js":369,"./zh-tw":370,"./zh-tw.js":370};function r(t){var e=l(t);return n(e)}function l(t){if(!n.o(map,t)){var e=new Error("Cannot find module '"+t+"'");throw e.code="MODULE_NOT_FOUND",e}return map[t]}r.keys=function(){return Object.keys(map)},r.resolve=l,t.exports=r,r.id=387},388:function(t){t.exports=JSON.parse('[{"id":1,"title":"Trở thành lập trình viên bạn cần gì","published_at":"2020-01-04 00:00:00","categories":[{"id":1,"title":"Chuyện của dev"}],"status":"published"},{"id":2,"title":"Cách trở thành lập trình viên nghìn đô","published_at":"2020-01-04 00:00:00","categories":[{"id":1,"title":"Chuyện của dev"}],"status":"published"},{"id":3,"title":"Series nhập môn lập trình với JavaScript","published_at":"2020-01-04 00:00:00","categories":[{"id":1,"title":"Chuyện của dev"}],"status":"published"},{"id":4,"title":"Động lực để bạn trở thành một lập trình viên","published_at":"2020-01-04 00:00:00","categories":[{"id":1,"title":"Chuyện của dev"}],"status":"published"},{"id":5,"title":"Nên học ngôn ngữ lập trình nào","published_at":"2020-01-04 00:00:00","categories":[{"id":1,"title":"Chuyện của dev"}],"status":"published"},{"id":6,"title":"Cách để học một công nghệ mới hiệu quả","published_at":"2020-01-04 00:00:00","categories":[{"id":1,"title":"Chuyện của dev"}],"status":"published"},{"id":7,"title":"8 cách để học dốt lập trình","published_at":"2020-01-04 00:00:00","categories":[{"id":1,"title":"Chuyện của dev"}],"status":"published"},{"id":8,"title":"Kinh nghiệm mua máy tính cho developer","published_at":"2020-01-04 00:00:00","categories":[{"id":1,"title":"Chuyện của dev"}],"status":"published"},{"id":9,"title":"Web developer 2019 nên học những gì","published_at":"2020-01-04 00:00:00","categories":[{"id":1,"title":"Chuyện của dev"}],"status":"published"}]')},436:function(t,e,n){"use strict";n.r(e);n(35),n(12),n(13),n(5),n(26),n(136),n(33);var r=n(4),l=n(9),c=(n(223),n(37)),o=(n(220),[{id:"published",title:"Đã đăng"},{id:"draft",title:"Nháp"}]);var h=n(218),d=n.n(h);var f=n(232),v=n(234),m={props:{total:{type:Number,default:1},current:{type:Number,default:1},perpage:{type:Number,default:15},range:{type:Number,default:9}},computed:{show:function(){return this.total>0},totalPage:function(){return Math.ceil(this.total/this.perpage)},ranges:function(){var t=0,e=0;if(this.perpage<this.total){(this.current-1)*this.perpage;var n=Math.ceil(this.range/2);this.totalPage<this.range?(t=1,e=this.totalPage):(t=this.current-n+1,e=this.current+n-1,t<1?(t=1,e=this.range):e>this.totalPage&&(e=this.totalPage,t=this.totalPage-this.range+1))}return{min:t,max:e}},min:function(){return this.ranges.min},max:function(){return this.ranges.max},minToMax:function(){for(var t=[],i=this.min;i<=this.max;i++)t.push(i);return t}},methods:{nextEvent:function(){this.$emit("change",this.current+1)},prevEvent:function(){this.$emit("change",this.current-1)},firstEvent:function(){this.$emit("change",1)},lastEvent:function(){this.$emit("change",this.totalPage)},changeEvent:function(t){this.$emit("change",t)}}},j=n(3),y=Object(j.a)(m,(function(){var t=this,e=t.$createElement,n=t._self._c||e;return t.totalPage>1?n("nav",[n("ul",{staticClass:"pagination justify-content-center"},[t.current>1?[n("li",{staticClass:"page-item"},[n("a",{staticClass:"page-link",attrs:{href:"#first"},on:{click:function(e){return e.preventDefault(),t.firstEvent(e)}}},[t._v("Trang đầu")])]),t._v(" "),n("li",{staticClass:"page-item"},[n("a",{staticClass:"page-link",attrs:{href:"#prev"},on:{click:function(e){return e.preventDefault(),t.prevEvent(e)}}},[t._v("Trang trước")])])]:t._e(),t._v(" "),t._l(t.minToMax,(function(i){return n("li",{key:i,staticClass:"page-item",class:{active:t.current===i}},[n("a",{staticClass:"page-link",attrs:{href:"#change"},on:{click:function(e){return e.preventDefault(),t.changeEvent(i)}}},[t._v(t._s(i))])])})),t._v(" "),t.current<t.totalPage?[n("li",{staticClass:"page-item"},[n("a",{staticClass:"page-link",attrs:{href:"#next"},on:{click:function(e){return e.preventDefault(),t.nextEvent(e)}}},[t._v("Trang tiếp")])]),t._v(" "),n("li",{staticClass:"page-item"},[n("a",{staticClass:"page-link",attrs:{href:"#last"},on:{click:function(e){return e.preventDefault(),t.lastEvent(e)}}},[t._v("Trang cuối")])])]:t._e()],2)]):t._e()}),[],!1,null,null,null).exports,_=n(388),k=n(235);function C(object,t){var e=Object.keys(object);if(Object.getOwnPropertySymbols){var n=Object.getOwnPropertySymbols(object);t&&(n=n.filter((function(t){return Object.getOwnPropertyDescriptor(object,t).enumerable}))),e.push.apply(e,n)}return e}var w={components:{categoriesSelect:f.a,smartTable:v.a,pagination:y},filters:{articleStatusTitle:function(t){return o.find((function(e){return e.id==t})).title},dateFormat:function(t){var e=arguments.length>1&&void 0!==arguments[1]?arguments[1]:"DD/MM/YYYY";return d()(t).format(e)}},asyncData:function(t){t.params;var e=t.query;return{articles:_,total:0,filters:{page:e.page&&e.page>=1?Number(e.page):1,status:e.status||"all",category_id:e.category_id||null,keyword:e.keyword||""},isLoading:!1}},created:function(){this.setActivedMenu(["blog","article"]),this["blog/category/fetch"](),this.fetchData()},methods:function(t){for(var i=1;i<arguments.length;i++){var source=null!=arguments[i]?arguments[i]:{};i%2?C(Object(source),!0).forEach((function(e){Object(l.a)(t,e,source[e])})):Object.getOwnPropertyDescriptors?Object.defineProperties(t,Object.getOwnPropertyDescriptors(source)):C(Object(source)).forEach((function(e){Object.defineProperty(t,e,Object.getOwnPropertyDescriptor(source,e))}))}return t}({fetchData:function(){var t=this;return Object(r.a)(regeneratorRuntime.mark((function e(){var n,r;return regeneratorRuntime.wrap((function(e){for(;;)switch(e.prev=e.next){case 0:return t.isLoading=!0,e.next=3,k.a.getList(t.filters);case 3:n=e.sent,r=n.data,t.articles=r.data,t.total=r.total,t.perpage=r.per_page,t.isLoading=!1;case 9:case"end":return e.stop()}}),e)})))()},changeTab:function(t){if("published"==t)this.filters.status="published";else if("draft"==t)this.filters.status="draft";else{if("all"!=t)throw"Không hiểu tab "+t;this.filters.status="all"}},isActiveTab:function(t){return this.filters.status==t},updateBrowserUrl:function(){this.$router.push({path:this.$route.path,query:this.filters})},search:function(){this.fetchData(),this.updateBrowserUrl()},deleteArticle:function(article){var t=this;return Object(r.a)(regeneratorRuntime.mark((function e(){var n;return regeneratorRuntime.wrap((function(e){for(;;)switch(e.prev=e.next){case 0:return e.next=2,t.$alert.fire({title:"Bạn có chắc chắn muốn xóa?",text:"Sau khi xóa sẽ không thể khôi phục!",icon:"warning",showCancelButton:!0,confirmButtonText:"Xóa",cancelButtonText:"Hủy"});case 2:if(n=e.sent,!n.value){e.next=9;break}return e.next=7,k.a.delete(article.id);case 7:t.$toast.fire({icon:"success",title:"Đã xóa"}),t.fetchData();case 9:case"end":return e.stop()}}),e)})))()},changePage:function(t){this.filters.page=t}},Object(c.b)(["setActivedMenu","blog/category/fetch"])),watch:{"filters.page":function(){this.search()},"filters.category_id":function(){this.changePage(1),this.search()},"filters.keyword":function(){this.changePage(1),this.search()},"filters.status":function(){this.changePage(1),this.search()}}},x=Object(j.a)(w,(function(){var t=this,e=t.$createElement,n=t._self._c||e;return n("div",{staticClass:"content-wrapper"},[n("div",{staticClass:"content-header"},[n("div",{staticClass:"container-fluid"},[n("div",{staticClass:"d-flex align-items-center"},[t._m(0),t._v(" "),n("div",{staticClass:"mr-auto"},[n("button",{staticClass:"btn btn-outline-danger btn-xs",attrs:{to:"/blog/articles/create"},on:{click:function(e){return e.preventDefault(),t.$router.push("/blog/articles/create")}}},[t._v("Viết bài mới")])])])])]),t._v(" "),n("div",{staticClass:"content"},[n("div",{staticClass:"container-fluid"},[n("div",{staticClass:"card card-danger card-outline card-outline-tabs"},[n("div",{staticClass:"card-header p-0 border-bottom-0"},[n("ul",{staticClass:"nav nav-tabs",attrs:{id:"custom-tabs-four-tab",role:"tablist"}},[n("li",{staticClass:"nav-item"},[n("a",{staticClass:"nav-link text-dark",class:{active:t.isActiveTab("all")},attrs:{href:"#all",role:"tab"},on:{click:function(e){return e.preventDefault(),t.changeTab("all")}}},[t._v("Tất cả bài viết")])]),t._v(" "),n("li",{staticClass:"nav-item"},[n("a",{staticClass:"nav-link text-dark",class:{active:t.isActiveTab("published")},attrs:{href:"#published",role:"tab"},on:{click:function(e){return e.preventDefault(),t.changeTab("published")}}},[t._v("Bài đã đăng")])]),t._v(" "),n("li",{staticClass:"nav-item"},[n("a",{staticClass:"nav-link text-dark",class:{active:t.isActiveTab("draft")},attrs:{href:"#draft",role:"tab"},on:{click:function(e){return e.preventDefault(),t.changeTab("draft")}}},[t._v("Bài nháp")])])])]),t._v(" "),n("form",{staticClass:"card-body border-bottom",on:{submit:function(e){return e.preventDefault(),t.search(e)}}},[n("div",{staticClass:"d-flex"},[n("div",{staticClass:"mr-3",staticStyle:{"min-width":"250px"}},[n("categories-select",{model:{value:t.filters.category_id,callback:function(e){t.$set(t.filters,"category_id",e)},expression:"filters.category_id"}})],1),t._v(" "),n("div",{staticClass:"w-100 mr-3"},[n("input",{directives:[{name:"model",rawName:"v-model.lazy",value:t.filters.keyword,expression:"filters.keyword",modifiers:{lazy:!0}},{name:"debounce",rawName:"v-debounce",value:500,expression:"500"}],staticClass:"form-control",attrs:{type:"text",placeholder:"Nhập từ khóa tìm kiếm"},domProps:{value:t.filters.keyword},on:{change:function(e){return t.$set(t.filters,"keyword",e.target.value)}}})]),t._v(" "),t._m(1)])]),t._v(" "),n("div",{staticClass:"card-body table-responsive p-0"},[n("smart-table",{attrs:{loading:t.isLoading}},[n("thead",[n("tr",[n("th",[t._v("Tên bài viết")]),t._v(" "),n("th",{staticClass:"date-format"},[t._v("Ngày đăng")]),t._v(" "),n("th",[t._v("Trạng thái")]),t._v(" "),n("th",[t._v("Danh mục")]),t._v(" "),n("th")])]),t._v(" "),n("tbody",t._l(t.articles,(function(article){return n("tr",[n("td",[n("nuxt-link",{staticClass:"text-primary",attrs:{to:"/blog/articles/"+article.id+"/edit"}},[t._v(t._s(article.title))])],1),t._v(" "),n("td",{staticClass:"date-format"},[t._v(t._s(t._f("dateFormat")(article.published_at)))]),t._v(" "),n("td",[n("span",{staticClass:"tag tag-success"},[t._v(t._s(t._f("articleStatusTitle")(article.status)))])]),t._v(" "),n("td",[t._v("\n                  "+t._s(article.categories.map((function(t){return t.title})).join(", "))+"\n                ")]),t._v(" "),n("td",{staticClass:"action-col"},[n("button",{staticClass:"btn border-0 btn-outline-secondary dropdown-toggle btn-xs clear-after",attrs:{type:"button","data-toggle":"dropdown","aria-expanded":"false"}},[n("i",{staticClass:"fas fa-ellipsis-v"})]),t._v(" "),n("ul",{staticClass:"dropdown-menu border-0"},[n("li",[n("nuxt-link",{staticClass:"dropdown-item",attrs:{to:"/blog/articles/"+article.id+"/edit"}},[t._v("Chỉnh sửa")])],1),t._v(" "),n("li",[n("a",{staticClass:"dropdown-item",attrs:{href:article.public_url}},[t._v("Xem ngoài trang chủ")])]),t._v(" "),n("li",{staticClass:"dropdown-divider"}),t._v(" "),n("li",[n("a",{staticClass:"dropdown-item text-danger",attrs:{href:"#"},on:{click:function(e){return e.preventDefault(),t.deleteArticle(article)}}},[t._v("Xóa")])])])])])})),0)])],1),t._v(" "),n("div",{staticClass:"card-footer clearfix"},[n("pagination",{attrs:{total:t.total,current:t.filters.page},on:{change:t.changePage}})],1)])])])])}),[function(){var t=this.$createElement,e=this._self._c||t;return e("div",{staticClass:"mr-4"},[e("h1",{staticClass:"m-0 text-dark"},[this._v("Danh sách bài viết")])])},function(){var t=this.$createElement,e=this._self._c||t;return e("div",[e("button",{staticClass:"btn btn-danger",staticStyle:{"min-width":"100px"},attrs:{type:"submit",placeholder:"Tìm kiếm theo tên bài viết"}},[this._v("Tìm kiếm")])])}],!1,null,null,null);e.default=x.exports}}]);