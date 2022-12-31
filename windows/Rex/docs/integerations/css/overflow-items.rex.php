@template('docs.integerations.template.co.format')

    @title('Css Integerations - Overflow')
    @style('build.css.tutorial:root:css')
    @style('build.css.headers:tutorial')

    <div class="padd-x-4"> <br>


        <div class="flex-in midv font-em-2 bc-silver rad-4 calibri">
            <a href="@domurl('docs/other-features/css')"><div class="fb-6 pxs-20 c-grey bc-silver-d pxv-10 mxr-10">Css</div></a>
            <div class="c-orange-dd">utility classes</div>
        </div><br>

        <span class="font-em-d85">
            <div class="wid-fit c-olive font-em-1d5">Overflow Items</div>
            Overflowing elements are either handled as <code>auto</code>, <code>hidden</code> or by using <code>scroll</code>. The scroll bar of an  
            overflowing content could be on the x or y axis. The following are list of classes that can be used for handling scroll bars 
            <ul>
                <li>
                    <code>flow-auto</code> - sets an overflow of auto scroll 
                </li>
                <li>
                    <code>flow-hide</code> - sets an overflow of hidden
                </li>
                <li>
                    <code>flow-x</code> - sets overflow of scroll only on x-axis while y-axis is hidden
                </li>
                <li>
                    <code>flow-y</code> - sets overflow of scroll only on y-axis while x-axis is hidden
                </li>
                <li>
                    <code>flow-scroll</code> -  sets an overflow of scroll
                </li>
            </ul>

            <div class="bc-silver">
                <div class="pxv-10 bc-silver-d">Example: flow-auto</div>
                <div class="flow-auto pxv-10 bc-silver" style="max-height: 120px">
                    Lorem ipsum dolor sit amet, consectetur adipisicing elit. Molestiae delectus incidunt vel rem iure natus, tenetur impedit, adipisci assumenda amet non magnam unde officiis culpa dolorem! Perferendis itaque facere provident?
                    Hic sequi, ad unde repellendus alias dolore maxime excepturi ducimus pariatur reprehenderit quos iusto, molestias nisi repudiandae nulla omnis atque modi sapiente itaque explicabo eaque eos delectus ut? Adipisci, ullam.
                    Optio facere corporis at veniam dolorum itaque? Quibusdam corrupti obcaecati quisquam reprehenderit. Sequi nam quisquam quasi repellendus, nostrum culpa ratione itaque. Magnam, ipsum omnis. Maiores, eum saepe. Harum, dolore neque.
                    Quidem ea repellat et provident inventore sed cupiditate, non iure dolores, quo obcaecati facere, quia eaque dolore rerum eum aperiam architecto magnam optio autem dignissimos. Veritatis omnis ipsa voluptatem possimus.
                    Sapiente iure praesentium sunt ratione voluptatum quam quod reiciendis dicta aliquam adipisci aspernatur facilis autem alias quia recusandae voluptates quaerat tempore, ea asperiores nemo! Nihil illum alias dolorem inventore iste!
                    Veniam tempore quasi, sequi dolorum magni perspiciatis, deserunt est temporibus ipsum vel quaerat quis culpa quia quo laborum. Repellat eaque fuga rem? Asperiores incidunt ratione libero impedit laboriosam aperiam. Itaque?
                    Perferendis, molestias! Fugit sit tenetur at tempora ab repudiandae veritatis quod rem possimus laudantium! Optio rem deleniti at praesentium! Ullam sed et distinctio officia magnam nisi, ea ab sequi facere.
                    Assumenda error accusantium quasi itaque vero libero dolor beatae odio dolorum, corrupti temporibus amet fugit eum doloremque explicabo recusandae ab architecto soluta officiis reprehenderit corporis voluptatibus ratione consequuntur dolores. Mollitia?
                    Non dolores maiores nemo consectetur voluptas voluptatum tempora labore illum impedit iste quidem laboriosam vero ducimus unde libero, excepturi, expedita iusto minima. Tempora aspernatur numquam illo cum culpa vel suscipit.
                    Nostrum error sint laboriosam nam commodi atque doloremque corporis fugiat, itaque cupiditate mollitia fuga expedita. Laborum perspiciatis corporis, ut libero omnis earum rem, aut eius nihil optio, consequatur iusto deserunt!
    
                </div>
            </div> <br>

            <div class="bc-silver">
                <div class="pxv-10 bc-silver-d">Example: flow-hide</div>
                <div class="flow-hide pxv-10 bc-silver" style="max-height: 120px">
                    Lorem ipsum dolor sit amet, consectetur adipisicing elit. Molestiae delectus incidunt vel rem iure natus, tenetur impedit, adipisci assumenda amet non magnam unde officiis culpa dolorem! Perferendis itaque facere provident?
                    Hic sequi, ad unde repellendus alias dolore maxime excepturi ducimus pariatur reprehenderit quos iusto, molestias nisi repudiandae nulla omnis atque modi sapiente itaque explicabo eaque eos delectus ut? Adipisci, ullam.
                    Optio facere corporis at veniam dolorum itaque? Quibusdam corrupti obcaecati quisquam reprehenderit. Sequi nam quisquam quasi repellendus, nostrum culpa ratione itaque. Magnam, ipsum omnis. Maiores, eum saepe. Harum, dolore neque.
                    Quidem ea repellat et provident inventore sed cupiditate, non iure dolores, quo obcaecati facere, quia eaque dolore rerum eum aperiam architecto magnam optio autem dignissimos. Veritatis omnis ipsa voluptatem possimus.
                    Sapiente iure praesentium sunt ratione voluptatum quam quod reiciendis dicta aliquam adipisci aspernatur facilis autem alias quia recusandae voluptates quaerat tempore, ea asperiores nemo! Nihil illum alias dolorem inventore iste!
                    Veniam tempore quasi, sequi dolorum magni perspiciatis, deserunt est temporibus ipsum vel quaerat quis culpa quia quo laborum. Repellat eaque fuga rem? Asperiores incidunt ratione libero impedit laboriosam aperiam. Itaque?
                    Perferendis, molestias! Fugit sit tenetur at tempora ab repudiandae veritatis quod rem possimus laudantium! Optio rem deleniti at praesentium! Ullam sed et distinctio officia magnam nisi, ea ab sequi facere.
                    Assumenda error accusantium quasi itaque vero libero dolor beatae odio dolorum, corrupti temporibus amet fugit eum doloremque explicabo recusandae ab architecto soluta officiis reprehenderit corporis voluptatibus ratione consequuntur dolores. Mollitia?
                    Non dolores maiores nemo consectetur voluptas voluptatum tempora labore illum impedit iste quidem laboriosam vero ducimus unde libero, excepturi, expedita iusto minima. Tempora aspernatur numquam illo cum culpa vel suscipit.
                    Nostrum error sint laboriosam nam commodi atque doloremque corporis fugiat, itaque cupiditate mollitia fuga expedita. Laborum perspiciatis corporis, ut libero omnis earum rem, aut eius nihil optio, consequatur iusto deserunt!
    
                </div>
            </div> <br>

            <div class="bc-silver">
                <div class="pxv-10 bc-silver-d">Example: flow-x</div>
                <div class="flow-x pxv-10 bc-silver no-wrap" style="max-height: 120px">
                    Lorem ipsum dolor sit amet, consectetur adipisicing elit. Molestiae delectus incidunt vel rem iure natus, tenetur impedit, adipisci assumenda amet non magnam unde officiis culpa dolorem! Perferendis itaque facere provident?
                    Hic sequi, ad unde repellendus alias dolore maxime excepturi ducimus pariatur reprehenderit quos iusto, molestias nisi repudiandae nulla omnis atque modi sapiente itaque explicabo eaque eos delectus ut? Adipisci, ullam.
                    Optio facere corporis at veniam dolorum itaque? Quibusdam corrupti obcaecati quisquam reprehenderit. Sequi nam quisquam quasi repellendus, nostrum culpa ratione itaque. Magnam, ipsum omnis. Maiores, eum saepe. Harum, dolore neque.
                    Quidem ea repellat et provident inventore sed cupiditate, non iure dolores, quo obcaecati facere, quia eaque dolore rerum eum aperiam architecto magnam optio autem dignissimos. Veritatis omnis ipsa voluptatem possimus.
                    Sapiente iure praesentium sunt ratione voluptatum quam quod reiciendis dicta aliquam adipisci aspernatur facilis autem alias quia recusandae voluptates quaerat tempore, ea asperiores nemo! Nihil illum alias dolorem inventore iste!
                    Veniam tempore quasi, sequi dolorum magni perspiciatis, deserunt est temporibus ipsum vel quaerat quis culpa quia quo laborum. Repellat eaque fuga rem? Asperiores incidunt ratione libero impedit laboriosam aperiam. Itaque?
                    Perferendis, molestias! Fugit sit tenetur at tempora ab repudiandae veritatis quod rem possimus laudantium! Optio rem deleniti at praesentium! Ullam sed et distinctio officia magnam nisi, ea ab sequi facere.
                    Assumenda error accusantium quasi itaque vero libero dolor beatae odio dolorum, corrupti temporibus amet fugit eum doloremque explicabo recusandae ab architecto soluta officiis reprehenderit corporis voluptatibus ratione consequuntur dolores. Mollitia?
                    Non dolores maiores nemo consectetur voluptas voluptatum tempora labore illum impedit iste quidem laboriosam vero ducimus unde libero, excepturi, expedita iusto minima. Tempora aspernatur numquam illo cum culpa vel suscipit.
                    Nostrum error sint laboriosam nam commodi atque doloremque corporis fugiat, itaque cupiditate mollitia fuga expedita. Laborum perspiciatis corporis, ut libero omnis earum rem, aut eius nihil optio, consequatur iusto deserunt!
    
                </div>
            </div> <br>

            <div class="bc-silver">
                <div class="pxv-10 bc-silver-d">Example: flow-y</div>
                <div class="flow-y pxv-10 bc-silver" style="max-height: 120px">
                    Lorem ipsum dolor sit amet, consectetur adipisicing elit. Molestiae delectus incidunt vel rem iure natus, tenetur impedit, adipisci assumenda amet non magnam unde officiis culpa dolorem! Perferendis itaque facere provident?
                    Hic sequi, ad unde repellendus alias dolore maxime excepturi ducimus pariatur reprehenderit quos iusto, molestias nisi repudiandae nulla omnis atque modi sapiente itaque explicabo eaque eos delectus ut? Adipisci, ullam.
                    Optio facere corporis at veniam dolorum itaque? Quibusdam corrupti obcaecati quisquam reprehenderit. Sequi nam quisquam quasi repellendus, nostrum culpa ratione itaque. Magnam, ipsum omnis. Maiores, eum saepe. Harum, dolore neque.
                    Quidem ea repellat et provident inventore sed cupiditate, non iure dolores, quo obcaecati facere, quia eaque dolore rerum eum aperiam architecto magnam optio autem dignissimos. Veritatis omnis ipsa voluptatem possimus.
                    Sapiente iure praesentium sunt ratione voluptatum quam quod reiciendis dicta aliquam adipisci aspernatur facilis autem alias quia recusandae voluptates quaerat tempore, ea asperiores nemo! Nihil illum alias dolorem inventore iste!
                    Veniam tempore quasi, sequi dolorum magni perspiciatis, deserunt est temporibus ipsum vel quaerat quis culpa quia quo laborum. Repellat eaque fuga rem? Asperiores incidunt ratione libero impedit laboriosam aperiam. Itaque?
                    Perferendis, molestias! Fugit sit tenetur at tempora ab repudiandae veritatis quod rem possimus laudantium! Optio rem deleniti at praesentium! Ullam sed et distinctio officia magnam nisi, ea ab sequi facere.
                    Assumenda error accusantium quasi itaque vero libero dolor beatae odio dolorum, corrupti temporibus amet fugit eum doloremque explicabo recusandae ab architecto soluta officiis reprehenderit corporis voluptatibus ratione consequuntur dolores. Mollitia?
                    Non dolores maiores nemo consectetur voluptas voluptatum tempora labore illum impedit iste quidem laboriosam vero ducimus unde libero, excepturi, expedita iusto minima. Tempora aspernatur numquam illo cum culpa vel suscipit.
                    Nostrum error sint laboriosam nam commodi atque doloremque corporis fugiat, itaque cupiditate mollitia fuga expedita. Laborum perspiciatis corporis, ut libero omnis earum rem, aut eius nihil optio, consequatur iusto deserunt!
                </div>
            </div> <br>

            It is important to note that <code>flow-x</code> sets the <code>overflow-y</code> property to "hidden" while the <code>flow-y</code> sets the <code>overflow-x</code> to hidden.
        </span>

    </div> <br>

@template;