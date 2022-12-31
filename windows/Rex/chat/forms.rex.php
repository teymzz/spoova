@template('template.t-chat')
        
        @lay('build.chatBuild:log_head')

        <div class="grid-center vh-95">
            <div class="user-box pxv-20" style="width:35%">
                @if(isset($validated)):
                    Form Submitted successfully
                @else:
                    {{ $Form? }}
                @endif;
            </div>
        </div>

@template;