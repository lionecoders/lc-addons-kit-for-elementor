(function(){
  const INST=new WeakMap(),DF={slidesPerView:4,spaceBetween:15,loop:false,speed:1000,slidesPerGroup:1,breakpoints:{320:{slidesPerView:1,spaceBetween:10},768:{slidesPerView:2,spaceBetween:10},1024:{slidesPerView:4,spaceBetween:15}}};

  function toEl(s){return s&&s.jquery? s[0] : s&&s.nodeType===1? s: document}
  function cfg(el){try{const r=(el.getAttribute&&el.getAttribute('data-config'))||'';return r?JSON.parse(r):{}}catch(e){return{}}}
  function initWidget(root){
    if(!root) return;
    const w = root.matches&&root.matches('.lcake-clients-slider')? root : root.closest? root.closest('.lcake-clients-slider') : root;
    if(!w) return;
    const c = w.querySelector('.lcake-main-swiper'); if(!c) return;
    if(typeof Swiper==='undefined') return setTimeout(()=>initWidget(root),120);
    const user = cfg(w);
    const opt = Object.assign({},DF,user);
    if(opt.autoplay){
      if(typeof opt.autoplay==='number') opt.autoplay={delay:opt.autoplay,disableOnInteraction:false,pauseOnMouseEnter:false};
      else opt.autoplay = Object.assign({delay:opt.speed||DF.speed,disableOnInteraction:false,pauseOnMouseEnter:!!opt.pauseOnHover},opt.autoplay);
    }
    const opts={slidesPerView:opt.slidesPerView,spaceBetween:opt.spaceBetween,loop:!!opt.loop,speed:opt.speed,slidesPerGroup:opt.slidesPerGroup,autoplay:opt.autoplay||false,breakpoints:opt.breakpoints,rtl:!!opt.rtl,observer:true,observeParents:true};
    const pag=w.querySelector('.swiper-pagination'); if(pag) opts.pagination={el:pag,clickable:true};
    const nx=w.querySelector('.swiper-button-next'),pv=w.querySelector('.swiper-button-prev'); if(nx&&pv) opts.navigation={nextEl:nx,prevEl:pv};
    const ex=INST.get(c);
    if(ex&&ex instanceof Swiper){
      try{ ex.params=Object.assign(ex.params||{},opts); ex.update&&ex.update(); c.dataset.lcClientLogoInitialized='true'; return }catch(e){ try{ ex.destroy(true,true) }catch(_){ } }
    }
    try{ INST.set(c,new Swiper(c,opts)); c.dataset.lcClientLogoInitialized='true' }catch(e){ setTimeout(()=>initWidget(root),200) }
  }
  function initAll(scope){
    const el=toEl(scope);
    if(el.matches&&el.matches('.lcake-clients-slider')) return initWidget(el);
    const n=el.querySelectorAll('.lcake-clients-slider');
    for(let i=0;i<n.length;i++) initWidget(n[i]);
  }
  function onReady(f){ if(document.readyState==='loading') document.addEventListener('DOMContentLoaded',f); else f() }

  onReady(()=>{
    initAll(document);
    if(window===window.parent){
      if(window.elementorFrontend&&window.elementorFrontend.hooks) try{ window.elementorFrontend.hooks.addAction('frontend/element_ready/lcake-kit-client-logo.default', ()=>{ initAll(document); Array.from(document.querySelectorAll('iframe')).forEach(ifr=>{ try{ ifr.contentWindow.postMessage({lcake:'init'},'*') }catch(e){} }) }) }catch(e){}
      if(window.elementor&&window.elementor.hooks) try{ window.elementor.hooks.addAction('panel/open_editor/widget/lcake-kit-client-logo', ()=>setTimeout(()=>{ initAll(document); Array.from(document.querySelectorAll('iframe')).forEach(ifr=>{ try{ ifr.contentWindow.postMessage({lcake:'init'},'*') }catch(e){} }) },220)) }catch(e){}
      if(window.elementor&&typeof window.elementor.on==='function') try{ window.elementor.on('preview:loaded', ()=>{ initAll(document); Array.from(document.querySelectorAll('iframe')).forEach(ifr=>{ try{ ifr.contentWindow.postMessage({lcake:'init'},'*') }catch(e){} }) }) }catch(e){}
    } else {
      window.addEventListener('message',e=>{ try{ if(e.data&&e.data.lcake==='init') initAll(document) }catch(err){} });
      if(window.elementorFrontend&&window.elementorFrontend.hooks) try{ window.elementorFrontend.hooks.addAction('frontend/element_ready/lcake-kit-client-logo.default', initAll) }catch(e){}
      if(window.elementor&&window.elementor.hooks) try{ window.elementor.hooks.addAction('panel/open_editor/widget/lcake-kit-client-logo', ()=>setTimeout(()=>initAll(),220)) }catch(e){}
      if(window.elementor&&typeof window.elementor.on==='function') try{ window.elementor.on('preview:loaded', ()=>initAll()) }catch(e){}
    }
    if('MutationObserver' in window){
      let t; new MutationObserver(m=>{ clearTimeout(t); t=setTimeout(()=>{ for(const mm of m) for(const n of mm.addedNodes) if(n.nodeType===1){ if(n.matches&&n.matches('.lcake-clients-slider')) initAll(n); else if(n.querySelector&&n.querySelector('.lcake-clients-slider')) initAll(n) } },120)}).observe(document.body,{childList:true,subtree:true});
    }
  });

  window.lcakeClientLogo={init:initAll};
})();