import{_ as m}from"./CesEUQ3j.js";import{d as f,I as i,r as _,c as s,e as c,J as e,X as h,g as u,F as v,an as k,n as g,p as w,j as b,f as I,l as x}from"./BbUMaPtt.js";const B=t=>(w("data-v-8d3f9ec1"),t=t(),b(),t),S={key:1,class:"loaded"},C=["poster"],V=["src"],$=["src","type"],N=["autoplay","src"],j=B(()=>I("button",null,null,-1)),E=[j],F=f({__name:"VideoPlayer",props:{poster:{type:String,default:""},src:{type:String,default:""},sources:{type:Array,default:()=>[]},autoplay:{type:Boolean,default:!1}},setup(t){const r=t,a=i(()=>{if(r.src&&r.src.includes("youtube.com/watch")){const o=r.src.match(/\?v=([^&]*)/);return{name:"youtube",src:`https://www.youtube-nocookie.com/embed/${(o==null?void 0:o[1])||""}?autoplay=1`,poster:r.poster||`https://i3.ytimg.com/vi/${(o==null?void 0:o[1])||""}/hqdefault.jpg`}}}),p=_(!1);if(!r.src&&!r.sources.length)throw new Error("VideoPlayer: you need to provide either `src` or `sources` props");const d=i(()=>{var o,l;return r.src||((l=(o=r.sources)==null?void 0:o[0])==null?void 0:l.src)||!1});return(o,l)=>{const y=m;return s(),c("div",{class:g(["video-player",{loaded:e(p)}])},[(e(a)?e(a).poster:t.poster)?(s(),h(y,{key:0,src:e(a)?e(a).poster:t.poster},null,8,["src"])):u("",!0),e(p)?(s(),c("div",S,[e(a)?e(a).name==="youtube"?(s(),c("iframe",{key:1,allow:"accelerometer; autoplay; encrypted-media; gyroscope; picture-in-picture",allowfullscreen:"true",autoplay:t.autoplay,src:e(a).src},null,8,N)):u("",!0):(s(),c("video",{key:0,poster:t.poster,controls:"",autoplay:""},[e(d)?(s(),c("source",{key:0,src:e(d)},null,8,V)):u("",!0),(s(!0),c(v,null,k(t.sources,n=>(s(),c("source",{key:n.src||n,src:n.src||n,type:n.type},null,8,$))),128))],8,C))])):u("",!0),e(p)?u("",!0):(s(),c("div",{key:2,class:"play-button",onClick:l[0]||(l[0]=n=>p.value=!0)},E))],2)}}}),z=x(F,[["__scopeId","data-v-8d3f9ec1"]]);export{z as default};
