import{d as v,ap as h,r as m,I as y,c as e,e as o,J as i,g as p,f as t,F as f,an as C,p as b,j as k,t as g,l as I}from"./Db_brTuD.js";const c=s=>(b("data-v-9a80bdbd"),s=s(),k(),s),S={key:0,class:"copied"},w=c(()=>t("div",{class:"scrim"},null,-1)),x=c(()=>t("div",{class:"content"}," Copied! ",-1)),B=[w,x],T=c(()=>t("div",{class:"header"},[t("div",{class:"controls"},[t("div"),t("div"),t("div")]),t("div",{class:"title"}," Bash ")],-1)),j={class:"window"},F=c(()=>t("span",{class:"sign"},"$",-1)),N={class:"content"},V={key:1,class:"prompt"},q=v({__name:"Terminal",props:{content:{type:[Array,String],required:!0}},setup(s){const a=s,{copy:l}=h(),n=m("init"),d=y(()=>typeof a.content=="string"?[a.content]:a.content),_=u=>{l(d.value.join(`
`)).then(()=>{n.value="copied",setTimeout(()=>{n.value="init"},1e3)}).catch(()=>{console.warn("Couldn't copy to clipboard!")})};return(u,A)=>(e(),o("div",{class:"terminal",onClick:_},[i(n)==="copied"?(e(),o("div",S,B)):p("",!0),T,t("div",j,[(e(!0),o(f,null,C(i(d),r=>(e(),o("span",{key:r,class:"line"},[F,t("span",N,g(r),1)]))),128))]),i(n)!=="copied"?(e(),o("div",V," Click to copy ")):p("",!0)]))}}),E=I(q,[["__scopeId","data-v-9a80bdbd"]]);export{E as default};