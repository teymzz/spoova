
  
  @template('template.t-html')
        
    @layout:form 
        <!-- add css -->
        @res('res/assets/css/index.css') 
        @style('build.css.inc:t-doc:index')


        <section>

            <div class="maincover centre">      

                <form method="post" class="form-field" style="width: 350px">
                    @csrf
                    <div class="fm-d5 sp-1 wid-full">
                        <div class="flex-full f-col">
                            <div>
                                <span class="c-orange box-full pvs-8" @onShow('error', ':csrf', 'title') > @error(':csrf','title') </span>
                                <span class="c-orange box-full pvs-8" @onShow('error', ':mod')> @error(':mod') </span>
                                <span class="c-orange box-full pvs-8" @onShow('error', ':dbi')> @error(':dbi') </span>
                                <span class="c-orange box-full pvs-8" @onShow('error', 'user')> @error('user') </span>
                                <span class="c-orange box-full pvs-8">{{ Res::Flash('mod', 'no errors') }}</span>
                            </div>
                            <div class="i-flex-full-in rad-4">
                                <input type="text" class="flex-full pxv-4" name="user" placeholder="username" value="@post.user">
                            </div>
                        </div>
                        
                        <div class="flex-full f-col">
                            <div>
                                <span class="c-orange box-full pvs-8" @onShow('error', 'pass')> @error('pass') </span>
                            </div>
                            <div class="i-flex-full-in rad-4">
                                <input type="text" class="flex-full pxv-4" name="pass" placeholder="password" value="@post.pass">
                            </div>
                        </div>

                        <div class="flex f-col col-x-1">
                            <div class="flex-btn">
                                <button class="flex-btn bg-primary rad-4 c-white pxv-10" @btn('login') >Submit</button>
                            </div>
                            <div class="c-white">
                                <input type="checkbox" name="remember"> remember me
                            </div>
                            <div class="flex">
                                <div class="flex mid c-white font-menu font-em-1">
                                    <div class="flex">forgot password?</div>
                                    <div class="flex">
                                       <span class="mxs-6">or</span> 
                                       <span class="i"><a href="@domurl('signup')">sign up</a></span> 
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>

                </form>
                
            </div>
            
        </section>
    @layout;            
@template;
