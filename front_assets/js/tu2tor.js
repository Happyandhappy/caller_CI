window.wyzant=window.wyzant||{};window.wyzant.optimizely=(function(){function e(){var p=window.location.hostname;if(!(p==="www.wyzant.com"||p==="wallet.wyzant.com")){return;}if(typeof(optimizely)=="undefined"){return;}var t=window.location.search.match(/activeExperiments=([0-9,]+)/i),s=(t&&t[1]&&t[1].split(","))||[],r=optimizely.activeExperiments||[],k=s.concat(r),o=false,n='"experiments":[',l='"activeVariations":[';for(i=0;i<k.length;i++){var q=k[i];if(!h(q)){if(!o){n+=c(q);l+=d(q);}else{n+=","+c(q);l+=","+d(q);}o=true;j(q);}}l+="]";n+="]";var m="{"+n+","+l+"}";if(o){$.ajax({url:"https://www.wyzant.com/services/RecordABTestHandler.ashx",type:"POST",data:m,cache:false,xhrFields:{withCredentials:true}});}}function a(n){if(typeof(optimizely)=="undefined"){return;}var p=window.optimizely||[],k=(p.data&&p.data.experiments)||null,l={},o=false;if(k===null){return;}for(var m in k){if(k.hasOwnProperty(m)){l[m]=k[m].name;if(k[m].name.trim()===n.trim()){p.push(["activate",m]);e();o=true;break;}}}if(o===false){wyzant.logging.eLogger.logEvent("Optimizely","Failed to activate optimizely experiment.",{ExceptionType:"Optimizely.ExperimentNotFound",LogLevel:"Error",StackTrace:new Error().stack,ExceptionMessage:"Experiment '"+n+"' was not found.",CurrentExperiments:JSON.stringify(l)});}}function d(k){var n="";if(optimizely.data.state.variationMap[k].length==null){index=optimizely.data.state.variationMap[k];n=optimizely.data.experiments[k].variation_ids[index];}else{for(var l=0;l<optimizely.data.state.variationMap[k].length;l++){index=optimizely.data.state.variationMap[k][l];var m=optimizely.data.experiments[k].section_ids[l];if(l==0){n+=optimizely.data.sections[m].variation_ids[index];}else{n+=","+optimizely.data.sections[m].variation_ids[index];}}}return n;}function c(n){var p="",l=true,k="{";k+='"id":'+n+",";k+='"name":"'+optimizely.all_experiments[n].name+'",';k+='"sections":[';for(var m=0;m<optimizely.data.experiments[n].section_ids.length;m++){p=optimizely.data.experiments[n].section_ids[m];var q='{"id":'+p+',"name":"'+optimizely.data.sections[p].name+'"}';if(m==0){k+=q;}else{k+=","+q;}}k+="],";k+='"variations":[';if(optimizely.data.experiments[n].section_ids.length>0){for(var m=0;m<optimizely.data.experiments[n].section_ids.length;m++){p=optimizely.data.experiments[n].section_ids[m];for(var o=0;o<optimizely.data.sections[p].variation_ids.length;o++){var s=optimizely.data.sections[p].variation_ids[o];var r='{"id":'+s+',"name":"'+optimizely.data.variations[s].name+'", "sectionid":'+p+"}";if(l){l=false;k+=r;}else{k+=","+r;}}}}else{for(var m=0;m<optimizely.data.experiments[n].variation_ids.length;m++){var s=optimizely.data.experiments[n].variation_ids[m];var r='{"id":'+s+',"name":"'+optimizely.data.variations[s].name+'", "sectionid":0}';if(l){l=false;k+=r;}else{k+=","+r;}}}k+="]";k+="}";return k;}function j(k){if(!h(k)){var l=f("optimizely");if(l==null){l=k;}else{l+=","+k;}f("optimizely",l,{expires:120,path:"/"});}}function h(l){if(f("optimizely")==null){return false;}var m=f("optimizely").split(",");for(var k=0;k<m.length;k++){if(m[k]==l){return true;}}return false;}function g(o){var m=window.optimizely||{},k=(typeof m.activeExperiments==="object"&&m.activeExperiments||[]).join(","),p=(o||"").split("#"),q=p[0].split("?"),n=(q.length>1)?"&"+q[1]:"",l=(p.length>1)?"#"+p[1]:"";if(window.location.search.indexOf("activeExperiments=")<0){window.location=q[0]+"?activeExperiments="+k+n+l;}}function b(l,k){var n=window.location,m=n.search.replace("?","&");if(window.location.search.indexOf(l)<0){window.location="//"+n.host+n.pathname+"?"+l+(k===true?m:"")+n.hash;}}function f(n,o,l){if(arguments.length>1&&String(o)!=="[object Object]"){l=l||{};if(o===null||o===undefined){l.expires=-1;}if(typeof l.expires==="number"){var q=l.expires,m=l.expires=new Date();m.setDate(m.getDate()+q);}o=String(o);return(document.cookie=[encodeURIComponent(n),"=",l.raw?o:encodeURIComponent(o),l.expires?"; expires="+l.expires.toUTCString():"",l.path?"; path="+l.path:"",l.domain?"; domain="+l.domain:"",l.secure?"; secure":""].join(""));}l=o||{};var k,p=l.raw?function(r){return r;}:decodeURIComponent;return(k=new RegExp("(?:^|; )"+encodeURIComponent(n)+"=([^;]*)").exec(document.cookie))?p(k[1]):null;}return{activateExperimentByName:a,init:e,redirectToUrl:g,addQueryParametersToUrl:b};}());$(function(){wyzant.optimizely.init();});