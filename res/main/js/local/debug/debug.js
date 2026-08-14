/**
 * This function is used for core debugging. 
 * This should not be tampered with
 * 
 */
function stack(element){

    let stackTrace = element.closest('[data-err="x-debug"]');
    let stackDebug;
    let stackDebugs;
    let stackBtns;

    if(element.closest('.error-bind')){
        stackTrace = element.closest('.error-bind');
    }

    stackBtns = stackTrace.querySelectorAll('.stack-btn');
    stackDebugs = stackTrace.querySelectorAll('.error-slide');

    if(element.classList.contains('stack-code-btn')){
        stackDebug = stackTrace.querySelector(".code-debug");
    }else{

        if(element.classList.contains('stack-window-btn')){
            stackDebug = stackTrace.querySelector(".window-debug");
        } else if(element.classList.contains('stack-message-btn')) {
            stackDebug = stackTrace.querySelector(".message-debug");
        } else if(element.classList.contains('stack-trace-btn')) {
            stackDebug = stackTrace.querySelector(".stack-trace");
        } else {
            stackDebug = stackTrace.querySelector(".stack-debug");
        }
    }
    
    let scrollHeight = `${stackDebug.scrollHeight}px`;
    
    stackDebugs.forEach( debug => {
        debug.classList.remove('opened');
    })

    if(stackDebug.classList.contains('opened')){
        scrollHeight = 0;
        stackDebug.classList.remove('opened')
        stackTrace.classList.remove('opened');
        element.classList.remove('opened');
    } else {
        element.classList.add('opened');
        stackDebug.classList.add('opened')
        stackTrace.classList.add('opened')
    }

    stackBtns.forEach(btn => {
        btn.classList.remove('active');
    })
    element.classList.add('active');

    let cssBuild = function(arg1, arg2){

        let cssText = (arg2 === undefined)? arg1 : arg2;
        
        let cssObj = cssText.split(";");
        let css = {};
        cssObj.forEach(obj => {
            let prop = obj.split(":");
            if (prop.length == 2){
                css[prop[0].trim()] = prop[1].trim();            
            }
        })
        
        if(arg2 !== undefined && arg1 != null){
            setTimeout(()=>{
                element = document.querySelector(arg1);
                
                if(element != null){
                    Object.assign(element.style, css);
                }            
            })
        }

        if(css) return css;
    }    

    let css = cssBuild(`height: ${scrollHeight};`);
    Object.assign(stackDebug.style, css);

}

/**
 * This file is loaded as type="module", so stack() is module scoped and the
 * onclick="stack(this)" printed on every tab button cannot see it. Exporting it
 * here rather than at the end of the setup below keeps the tab buttons alive even
 * if that setup finds nothing to show or fails part way through.
 */
window.stack = stack;

/**
 * Flattens the error panes before anything else reads them.
 *
 * A pane is printed where its error fires. When the page itself is broken the
 * markup around it is unbalanced, so the parser never closes one pane before the
 * next begins and they come out *nested* inside each other rather than as siblings.
 * On a real page this was 9 of 10 panes nested.
 *
 * That breaks the sublist move below, which assumes siblings: appendChild() on a
 * nested pane rips it out of its parent pane, and querySelector('.xe-sublist')
 * walks depth-first into a child pane's sublist. The result is a torn pane — an
 * emptied wrapper that still counts for the pager, and a loose .error-bind with no
 * ._black ancestor, which then renders on the light default.
 *
 * Re-appending each pane to the body in document order pulls every nested one back
 * out to the top level; the leftover passes then catch anything already broken.
 */
function xeRepairPanes(){

    let selector = `[data-err="x-debug"]:not([id="\:\:notice"])`;

    // flatten: appending in document order leaves every pane a sibling of the rest
    document.querySelectorAll(selector).forEach((pane) => {
        if(pane.parentElement && pane.parentElement.closest(selector)){
            document.body.appendChild(pane);
        }
    });

    // any .error-bind already separated from its wrapper gets one of its own
    document.querySelectorAll('.error-bind').forEach((errorBind) => {
        if(errorBind.closest('[data-err="x-debug"]')) return;

        let host = document.createElement('div');
        host.setAttribute('data-err', 'x-debug');
        host.setAttribute('hidden', true);
        host.setAttribute('class', 'xdebug-error custom-error-pane _black');

        errorBind.parentNode.insertBefore(host, errorBind);
        host.appendChild(errorBind);
    });

    // drop wrappers left with nothing to show, so the pager cannot land on a blank
    document.querySelectorAll(selector).forEach((pane) => {
        if(!pane.querySelector('.error-bind')) pane.remove();
    });

}

// a repair that throws must not take the rest of the debugger down with it
try{ xeRepairPanes(); }catch(e){ console.warn('x-debug: pane repair skipped', e); }

let XDebugger = document.querySelector(`[data-err="x-debug"]:not([id="\:\:notice"])`)
if(XDebugger){
    let XDebuggers = document.querySelectorAll(`[data-err="x-debug"]:not([id="\:\:notice"])`);

    let XEClass = XDebugger.querySelector('.error-class');
    let XELists = XDebugger.querySelector('.xe-sublist');

    if(XDebuggers.length > 1){
        let XEBell = document.createElement('div');
        XEBell.setAttribute('class','xe-tool relative');
        XEBell.innerHTML = `
        <div class="xe-bell">
            <div class="font-11 flex mid">
                <div class="xe-notice-wrapper">
                    <div class="xe-notice relative" id="xe-errs-btn">
                        <div class="absolute" hidden id="xe-errs-pane">
                            <div style="padding: 4px">
                                <div class="flex xe-navs" data-xid="1">
                                    <div class="flex mid xe-nav-l xe-nav"><i class="bi-chevron-compact-left"></i></div> 
                                    <div class="flex mid xe-index">1</div> 
                                    <div class="flex mid xe-nav-r xe-nav"><i class="bi-chevron-compact-right"></i></div>
                                </div>
                            </div>
                        </div>
                        <i class="bi-exclamation-circle"></i>
                    </div>
                </div>
                <div class="xe-index">${XDebuggers.length}</div>
            </div>
        </div
            `;
    
        XDebugger.prepend(XEBell); //insert switcher controller btns
        const secureID = new Map();
        secureID.set('xid', 1);

        let XENavBtns = XEBell.querySelectorAll('.xe-nav');
        let XENavL = XEBell.querySelector('.xe-nav-l');
        let XENavR = XEBell.querySelector('.xe-nav-r');
        let XEDebugs = {};
        let XDebuggersCopy = {... XDebuggers}; //copy of all xdebug items
        XEDebugs[0] = XDebuggers[0].querySelector('.error-bind');
        delete XDebuggersCopy[0];
        XEDebugs = {...XEDebugs, ...XDebuggersCopy};
    
        XENavBtns.forEach((navBtn) => {
    
            navBtn.addEventListener('click', function(){
                let btn = (this.classList.contains('xe-nav-l'))? 'left' : 'right';
    
                let xid = this.closest('[data-xid]');
                let xeIndex = xid.querySelector('.xe-index');
                let navid = secureID.get('xid'); // fetch xid from map
                navid = parseInt(navid);
                
                if(navid > 0){
                    let newid = 0;
    
                    if(btn === 'left'){
                        newid = ((navid - 1) > 0)? navid-1 : 1;
                        XENavR.classList.remove('done')
                        if(newid === 1){
                            XENavL.classList.add('done')
                        }else{
                            XENavL.classList.remove('done')
                        }
                    }else {
                        newid = ((navid+1) <= Object.keys(XEDebugs).length)? navid+1 : Object.keys(XEDebugs).length
                        XENavL.classList.remove('done')
                        if(newid === Object.keys(XEDebugs).length){
                            XENavR.classList.add('done')
                        }else{
                            XENavR.classList.remove('done')
                        }
                    }
    
                    //hide other error fields 
                    for(let index in XEDebugs){
                        let i = parseInt(index) + 1;
                        if(i === newid){
                            XEDebugs[index].removeAttribute('hidden');
                        }else{
                            XEDebugs[index].setAttribute('hidden',true);
                        }
                        xid.setAttribute('data-xid', newid)
                        secureID.set('xid', newid);
                        xeIndex.innerHTML = newid;
                    }
                }
                
            })
            
        })
        XDebuggers.forEach((xdebugs, index) => {
            if(index > 0){
                // if(!XELists.contains(xdebugs)){
                    XELists.appendChild(xdebugs);
                // }
            }
        })  
    
        let XEBtn = document.getElementById('xe-errs-btn');
        let XEPane = document.getElementById('xe-errs-pane');
        let xeTimer;
    
        XEBtn.addEventListener('mouseenter', () => {
            if(xeTimer) clearTimeout(xeTimer);
            XEPane.hidden = null;
        });
        XEBtn.addEventListener('mouseleave', () => {
            xeTimer = setTimeout(() => {
                XEPane.hidden = true;
            }, 200)
        });
    }
    XDebugger.removeAttribute('hidden');
    try{ xeDraggable(); }catch(e){ console.warn('x-debug: drag unavailable', e); }
}

/**
 * Makes the error box draggable on a direct page load.
 *
 * Dragging only ever existed in the live server's isDraggable(), which also owns
 * the only rule that reveals the button — core.css keeps .mover[drag-btn] on
 * display:none until something shows it. So on a page the live server is not
 * watching, the handle was invisible and inert.
 *
 * Every pane is position:fixed at the same spot, so the position is written to all
 * of them: the box then stays where it was put when the bell pages to another error.
 */
function xeDraggable(){

    let selector = `[data-err="x-debug"]:not([id="\:\:notice"])`;
    let movers = document.querySelectorAll('.mover[drag-btn]');

    if(!movers.length) return;

    // the handle is revealed either way, but the live server owns the drag itself:
    // it wraps the fields in #::notice and moves that box. Binding here as well
    // would offset the field a second time, inside a parent that clips it. The live
    // server re-adds this file as a classic script once the fields exist, so this
    // function does run on live pages, unlike on the first pass at load.
    movers.forEach((mover) => mover.style.display = 'flex');

    if(document.getElementById('::notice')) return;

    // and a second evaluation must not stack a duplicate set of handlers
    if(window.xeDragBound) return;
    window.xeDragBound = true;

    let dragging = false, offsetY = 0;

    let point = (e) => e.touches? (e.touches[0] || e.changedTouches[0]) : e;

    let start = function(e){
        let box = this.closest(selector);
        if(!box) return;
        dragging = true;
        e.preventDefault();
        offsetY = point(e).clientY - box.getBoundingClientRect().top;
        document.body.classList.add('no-select');
    };

    let move = (e) => {
        if(!dragging) return;

        // measure against whichever pane is currently on screen
        let box = document.querySelector(selector + ':not([hidden])');
        if(!box) return;

        let touch = point(e);
        let x = (window.innerWidth - touch.clientX) / window.innerWidth * 100;
        let y = touch.clientY - offsetY;

        let maxX = 100 - box.clientWidth / window.innerWidth * 100;
        let maxY = window.innerHeight - box.clientHeight;

        let top   = Math.min(Math.max(y, 0), maxY) + 'px';
        let right = Math.min(Math.max(x, 0), maxX) + '%';

        document.querySelectorAll(selector).forEach((pane) => {
            pane.style.top = top;
            pane.style.right = right;
        });
    };

    let stop = () => {
        dragging = false;
        document.body.classList.remove('no-select');
    };

    movers.forEach((mover) => {
        mover.addEventListener('mousedown', start);
        mover.addEventListener('touchstart', start, {passive:false});
    });

    document.addEventListener('mousemove', move);
    document.addEventListener('touchmove', move);
    document.addEventListener('mouseup', stop);
    document.addEventListener('touchend', stop);

}