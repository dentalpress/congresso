/*
htmlGetSQL version 1.0.1/dpress-congresso beta
Copyright (c) 2014 fernando.fte@gmail.com – Fernando Truculo Evangelista
All Rights Reserved
 
This product is protected by copyright and distributed under
licenses restricting copying, distribution, and decompilation.
*/
$.submt_post=function(value){$.ajax({type:"post",url:"../congresso/assets/vendor/htmlGetSQL/php/json.post.php",cache:false,data:value,async:false}).done(function(e){return value=e});return eval(value)};$.parser_values_request=function(e,t,n){var r,i,s,o,u;s=function(t){switch(t.type){case"text":if(!t["return"]){t.me.html(t.val)}if(t["return"]){return e.html()}break;case"url":if(!t["return"]){t.me.attr({href:t.val})}if(t["return"]){return t.me.attr("href")}break;case"href":if(!t["return"]){t.me.attr({href:t.val})}if(t["return"]){return t.me.attr("href")}break;case"title":if(!t["return"]){t.me.attr({title:t.val})}if(t["return"]){return t.me.attr("title")}break;case"alt":if(!t["return"]){t.me.attr({alt:t.val})}if(t["return"]){return t.me.attr("alt")}break;case"src":if(!t["return"]){t.me.attr({src:t.val})}if(t["return"]){return t.me.attr("src")}break;case"input":if(!t["return"]){t.me.attr({value:t.val})}if(n["return"]){return e.attr("value")}break;case"chenge":if(!t["return"]){t.me.attr({value:t.val})}if(t["return"]){return t.me.attr("value")}break;case"disabled":if(!t["return"]){t.me.attr({disabled:t.val})}if(t["return"]){return t.me.attr("disabled")}break;case"class":if(!n["return"]){t.me.addClass(t.val)}if(t["return"]){return t.me.data("template-request-class",t.val)}break;case"template-toogle":if(!t["return"]){t.me.data("template-request-toogle",t.val)}if(t["return"]){return t.me.data("template-request-toogle")[t["return"]]}}};o={};if(!t||!t+""==="[object Object]"){if(t){o["return"]=t}if(!t){o["return"]={}}o.type=n;o.me;return s(o)}else{r=$.extract_object_value(t,{valida:n});i=0;u=[];while(i<r.length){$.each(r[i],function(t,n){o.me=e;o.type=t;o.val=n;return s(o)});u.push(i++)}return u}};$.extract_object_value=function(e,t){var n,r;n=function(e){switch(e){case"template-toogle":return false;default:return true}};if(!e.object){r=e;e={object:e}}$.each(e.object,function(i,s){var o,u;if(s+""==="[object Object]"){u=n(i);if(i==="template-toogle"){r={};r[i]=t.valida[i];e["return"].push(r)}if(u){o={};e.object=s;if(t.valida){o={}}if(t.valida&&t.valida[i]){o.valida=t.valida[i]}if(t.valida&&!t.valida[i]){o.valida={}}if(t.key){o={}}if(t.key&&t.key[i]){o.key=t.key[i]}if(t.key&&!t.key[i]){o.key={}}if(t.estrutura){o={}}if(t.estrutura){o.estrutura={}}if(t.estrutura){o.estrutura=t.estrutura+'["'+i+'"]'}if(t.estrutura&&t.estrutura==="estrutura"){o.estrutura='["'+i+'"]'}return $.extract_object_value(e,o)}}else{if(!e["return"]){e["return"]=[]}if(t.estrutura){t.estrutura=t.estrutura+'["'+i+'"]'}if(t.estrutura==='estrutura["'+i+'"]'||t.estrutura===""){t.estrutura='["'+i+'"]'}if(t.valida&&t.valida[i]){r={}}if(t.valida&&t.valida[i]){r[s]=t.valida[i]}if(t.key&&t.key[i]){r={}}if(t.key&&t.key[i]){r[i]=s}if(t.key&&t.key[i]){e["return"].push(r)}if(t.valida&&t.valida[i]){e["return"].push(r)}if(t.estrutura){e["return"].push(t.estrutura)}if(!t.valida&&!t.estrutura&&!t.key){return e["return"].push(s)}}});return e["return"]};$.pull_values=function(e){var t,n,r;n={};n.position=0;n.count={};t={};t.count=e.find("[data-template]").size();r=[];while(n["position"]<t.count){t[n["position"]]={};t[n["position"]].pull={};t[n["position"]]["this"]=e.find("[data-template]").eq(n["position"]);t[n["position"]].pull.type="select";t[n["position"]].pull.table=t[n["position"]]["this"].data("pull-table");t[n["position"]].pull.select=t[n["position"]]["this"].data("pull-select");t[n["position"]].data=t[n["position"]]["this"].data("template");if(t[n["position"]]["this"].data("push")){if(t[n["position"]]["this"].data("push").type){t[n["position"]].pull.status=t[n["position"]]["this"].data("push").type}}if(t[n["position"]].data==="me"){n["return"]=$.submt_post(t[n["position"]].pull);t[n["position"]]["this"].values=t[n["position"]]["this"].data("template-value");if(n["return"]){$.parser_values_request(t[n["position"]]["this"],t[n["position"]]["this"].values,n["return"]["0"])}}else if(t[n["position"]].data==="child"){n["return"]=$.submt_post(t[n["position"]].pull);t[n["position"]].childs={};t[n["position"]].childs.contents=t[n["position"]]["this"].find("[data-template-value]");t[n["position"]].childs.count=t[n["position"]].childs.contents.size();n["count"][n["position"]]=0;while(n["count"][n["position"]]<t[n["position"]].childs.count){t[n["position"]].childs.contents[n["count"][n["position"]]]["this"]=t[n["position"]].childs.contents.eq(n["count"][n["position"]]);t[n["position"]].childs.contents[n["count"][n["position"]]].values=t[n["position"]].childs.contents[n["count"][n["position"]]]["this"].data("template-value");if(n["return"]){$.parser_values_request(t[n["position"]].childs.contents[n["count"][n["position"]]]["this"],t[n["position"]].childs.contents[n["count"][n["position"]]].values,n["return"]["0"])}n["count"][n["position"]]++}delete n["return"]}else if(t[n["position"]].data==="gallery"){t[n["position"]].pull.regra={limit:""};n["return"]=$.submt_post(t[n["position"]].pull);n["count"][n["position"]]=0;t[n["position"]].gallery={};t[n["position"]].gallery.contents=t[n["position"]]["this"].find("[data-template-gallery]");while(n["count"][n["position"]]<n["return"].length-1){t[n["position"]].gallery.contents.clone().appendTo(t[n["position"]]["this"]);n["count"][n["position"]]++}n["count"][n["position"]]={};n["count"][n["position"]]["gallery"]=0;t[n["position"]].gallery={};t[n["position"]].gallery=t[n["position"]]["this"].find("[data-template-gallery]");while(n["count"][n["position"]]["gallery"]<n["return"].length){t[n["position"]].gallery["this"]=t[n["position"]].gallery.eq(n["count"][n["position"]]["gallery"]);t[n["position"]].gallery.childs={};t[n["position"]].gallery.childs.contents=t[n["position"]].gallery["this"].find("[data-template-value]");t[n["position"]].gallery.childs.count=t[n["position"]].gallery.childs.contents.size();n["count"][n["position"]]["child"]=0;if(t[n["position"]].gallery["this"].data("template-gallery")==="all"){t[n["position"]].gallery["this"].values=t[n["position"]].gallery["this"].data("template-value");$.parser_values_request(t[n["position"]].gallery["this"],t[n["position"]].gallery["this"].values,n["return"][n["count"][n["position"]]["gallery"]])}while(n["count"][n["position"]]["child"]<t[n["position"]].gallery.childs.count){t[n["position"]].gallery.childs.contents[n["count"][n["position"]]["child"]]["this"]=t[n["position"]].gallery.childs.contents.eq(n["count"][n["position"]]["child"]);t[n["position"]].gallery.childs.contents[n["count"][n["position"]]["child"]].values=t[n["position"]].gallery.childs.contents[n["count"][n["position"]]["child"]]["this"].data("template-value");$.parser_values_request(t[n["position"]].gallery.childs.contents[n["count"][n["position"]]["child"]]["this"],t[n["position"]].gallery.childs.contents[n["count"][n["position"]]["child"]].values,n["return"][n["count"][n["position"]]["gallery"]]);n["count"][n["position"]]["child"]++}n["count"][n["position"]]["gallery"]++}}r.push(n["position"]++)}return r}
