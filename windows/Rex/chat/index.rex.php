
@template('template.t-chat')

    @lay('build.chatBuild:log_head')

    <div class="grid-center vh-95">
        <div class="user-box flow-hide">

             <!-- header -->
             <div class="pxv-20 bc-white-dd c-orange-dd">
               <i class="bi-chat"></i> Start Chatting Now !!!
             </div>

            <!-- footer -->
            <div class="flex-full">
                <div class="footer flex-full pxv-20">
                    <div class="flex-full">
                        <div class="box mxr-10 bc-white-dd rad-r pxv-4">
                            <div class="px-40 rad-i bc-silver b-cover" data-src="@images('user.png')"></div>
                        </div>
                        <div class="flex-full f-col midh">
                            <span> User Account </span> 
                            <span class="c-silver-dd flex midl"> 
                              <div class="box pxv-4 bc-red rad-r mxr-6 flex-l"></div>  Offline 
                            </span>
                        </div>
                    </div>
                    <div class="flex-full flex-r">
                        
                        <a href="@route('login')">
                            <button class="btn btn-primary">
                                Login
                            </button>
                        </a>

                    </div>
                </div>
            </div>
            <div class="pxv-20">
                <div class="font-menu">
                    No account? <a href="@route('signup')"> sign up now </a>
                </div>
            </div>
        </div>
    </div>

@template;