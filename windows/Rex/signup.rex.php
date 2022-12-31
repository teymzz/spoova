
  
  @template('template.t-html')
        
        @layout:form 

            @res('res/assets/css/index.css') 
            @style('build.css.inc:t-doc:index')
    
            <section>
    
                <div class="maincover centre">      
    
                    <form method="post" class="form-field" style="width: 350px">
                        @csrf
                        <div class="fm-d5 sp-1 wid-full bc-silver pxv-14 rad-4">
                            <div class="flex-full c-blue">
                                Signup
                            </div>
                            <div class="flex-full f-col">
                                <div>
                                    <span class="c-orange box-full pvs-8" @onHide('error', ':csrf', 'title') > @error(':csrf','title') </span>
                                    <span class="c-orange box-full pvs-8" @onHide('error', ':mod')> @error(':mod') </span>
                                    <span class="c-orange box-full pvs-8" @onHide('error', ':dbi')> @error(':dbi') </span>
                                    <span class="c-orange box-full pvs-8" @onHide('error', 'firstname')> @error('firstname') </span>
                                </div>
                                <div class="i-flex-full-in rad-4">
                                    <input type="text" class="flex-full pxv-4" name="firstname" placeholder="firstname" value="@old.firstname">
                                </div>
                            </div>

                            <div class="flex-full f-col">
                                <div>
                                    <span class="c-orange box-full pvs-8" @onHide('error', 'lastname')> @error('lastname') </span>
                                </div>
                                <div class="i-flex-full-in rad-4">
                                    <input type="text" class="flex-full pxv-4" name="lastname" placeholder="lastname" value="@old.lastname">
                                </div>
                            </div>

                            <div class="flex-full f-col">
                                <div>
                                    <span class="c-orange box-full pvs-8" @onHide('error', 'user')> @error('user') </span>
                                </div>
                                <div class="i-flex-full-in rad-4">
                                    <input type="text" class="flex-full pxv-4" name="user" placeholder="username" value="@old.user">
                                </div>
                            </div>

                            <div class="flex-full f-col">
                                <div>
                                    <span class="c-orange box-full pvs-8" @onHide('error', 'email')> @error('email') </span>
                                </div>
                                <div class="i-flex-full-in rad-4">
                                    <input type="text" class="flex-full pxv-4" name="email" placeholder="email" value="@old.email">
                                </div>
                            </div>
                            
                            <div class="flex-full f-col">
                                <div>
                                    <span class="c-orange box-full pvs-8" @onHide('error', 'pass')> @error('pass') </span>
                                </div>
                                <div class="i-flex-full-in rad-4">
                                    <input type="password" class="flex-full pxv-4" name="pass" placeholder="password" value="@old.pass">
                                </div>
                            </div>
    
                            <div class="flex-grid col-x-1">
                                <div class="flex-btn">
                                    <button class="flex-btn bg-primary rad-4 c-white pxv-10" name="signup">Submit</button>
                                </div>
                                <div class="flex mid c-grey-dd font-menu font-em-1">
                                    <div class="flex">forgot password?</div>
                                    <div class="flex pxs-10">
                                       <span class="mxr-6">or</span> 
                                       <span class="i"><a href="@domurl('signup')">log in</a></span> 
                                    </div>
                                </div>
                            </div>
                        </div>
    
                    </form>
                    
                </div>
                
            </section>
        @layout;            
    @template;
    