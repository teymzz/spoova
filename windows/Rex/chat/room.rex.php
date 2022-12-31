@template('template.t-chat')
        
        @lay('build.chatBuild:log_head')

        <style>
            .view {
                width:calc(100% - 50px);
            }
            .chat-user-box{
                width:100%;
                height: 400px;
            }
            .chat-view-box{
                width: 70%;
            }

            .screen {
                width: 100%;
                padding: .5em;
                height:100%;
            }

            .screen .left-chat{
                box-shadow: 0 0 10px 0 #e0e0e0 inset;
                width:calc(100% - 130px);
                padding:1em;
                border-radius:  100vh 100vh 100vh 0;
                background-color: #efefef;
                color:#358c9a;
                float:left;
                margin-bottom: 1em;
            }

            .screen .right-chat{
                box-shadow: 0 0 10px 0 #3c8d9a inset;
                width:calc(100% - 130px);
                padding:1em;
                border-radius:  100vh 100vh 0 100vh;
                background-color: #53a8b6;
                color:white;
                float:right;
                position: relative;
                right: 3px;
                margin-bottom: 1em;
            }

            .message-box textarea.messenger{
                border: solid 1px #efefef;
                padding: .65em 1em;
                border-radius: 100vh !important;
                overflow: hidden;
                height: 40px;
            }

            @media(min-width:800px){
                .view {
                    width:calc(100% - 200px);
                }                
            }
        </style>

        <div class="grid">
            <div class="wid-full">
                <div class="pxv-10 font-em-1d5 flex mid v bc-off-white">
                    <div class="flex-full">
                        <i class="box bi-person px-30 rad-r bg-primary c-white flex mid mxr-10"></i> 
                        <span class="calibri">{{ User::id() }}</span>
                    </div>
                    <div class="flex">
                        <form method="post" action="@domUrl('index')">
                            <button class="btn btn-primary" name="logout">Logout</button>
                        </form>
                    </div>
                </div>
            </div>
        </div>
        <div class="flex mid vhm-80 pxs-4">
            <div class="view flex-full">
                
                <div class="flex-full flow-hide f-col chat-user-box user-box mxs-10">
                    <div class="flex-full bc-white-dd pxv-10">
                        <div class="flex-full">
                            <div class="flex mid no-wrap c-sky-blue-dd pxs-10">
                                <span class="flex mid bi-chat-dots c-white pxv-6 bc-sky-blue-dd mxr-4 rad-r"></span> 
                                <span class="flex">Chat Box</span>
                            </div>
                            <div class="flex-full midr">
                              <div class="px-40 mxs-2 bc-white-dd rad-r b-cover" data-src="@images('user.png')"></div>
                              <div class="rad-r font-em-1d2">
                                <span class="bi-wifi c-white in-flex mid px-40 bc-sky-blue-dd rad-r mxs-10 animate-clockwise"></span>
                              </div>
                              <div class="px-40 mxs-2 bc-white-dd rad-r b-cover" data-src="@images('user.png')"></div>
                            </div>
                        </div>
                    </div>
                    <div class="screen flow-hide">
                        <div class="inner-slide flow-y" style="height:100%">
                            <div class="grid-center c-silver-d no-select" style="height:50%">
                                Start Sending messages
                            </div>
                            <div class="pull-left wid-full">
                                <div class="flex-full flex-l pxs-4">
                                    <div class="px-40 rad-r circle b-cover mxr-4" data-src="@images('user.png')"></div>
                                    <div class="left-chat">Hey</div>
                                </div>
                            </div>
                            <div class="pull-right wid-full">
                                <div class="flex-full flex-r pxs-4">
                                    <div class="right-chat">Hey</div>
                                    <div class="px-40 rad-r circle b-cover mxr-4" data-src="@images('user.png')"></div>
                                </div>
                            </div>                            <div class="pull-left wid-full">
                                <div class="flex-full flex-l pxs-4">
                                    <div class="px-40 rad-r circle b-cover mxr-4" data-src="@images('user.png')"></div>
                                    <div class="left-chat">Hey</div>
                                </div>
                            </div>
                            <div class="pull-right wid-full">
                                <div class="flex-full flex-r pxs-4">
                                    <div class="right-chat">Hey</div>
                                    <div class="px-40 rad-r circle b-cover mxr-4" data-src="@images('user.png')"></div>
                                </div>
                            </div>                            <div class="pull-left wid-full">
                                <div class="flex-full flex-l pxs-4">
                                    <div class="px-40 rad-r circle b-cover mxr-4" data-src="@images('user.png')"></div>
                                    <div class="left-chat">Hey</div>
                                </div>
                            </div>
                            <div class="pull-right wid-full">
                                <div class="flex-full flex-r pxs-4">
                                    <div class="right-chat">Tanks</div>
                                    <div class="px-40 rad-r circle b-cover mxr-4" data-src="@images('user.png')"></div>
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="message-box i-flex-full pxv-10">
                        <textarea placeholder="send message" class="messenger flex-full c-silver-dd" style="resize:none"></textarea>
                        <div class="i-flex font-em-1d5">
                            <button class="bi-plane flex-btn"><i class="bi-telegram c-sky-blue-dd"></i></button>
                        </div>
                    </div>
                </div>

                <div class="chat-view-box mxs-10 users-box user-box">

                </div>
            </div>
        </div>

@template;