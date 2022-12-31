@template('docs.integerations.template.co.format')

    @title('Css Integerations - Responsive')
    @style('build.css.tutorial:root:css')
    @style('build.css.headers:tutorial')

    <div class="padd-x-4"> <br>
            
        <div class="flex-in midv font-em-2 bc-silver rad-4 calibri">
            <a href="@domurl('docs/other-features/css')"><div class="fb-6 pxs-20 c-grey bc-silver-d pxv-10 mxr-10">Css</div></a>
            <div class="c-orange-dd">utility classes</div>
        </div><br>

    </div>

    <div class="padd-x-4">


        <span class="font-em-d85">
            <div class="wid-fit c-olive font-em-1d5">Responsive Paddings</div>
            Responsiveness of elements is mostly achieved through paddings. The <code>xs-</code> utilty classes are set up specifically to handle 
            responsiveness based on 5 steps. Once any of the <code>xs-</code> class is applied, there is always a slight modification to content 
            padding within the range of these steps. The five steps are screen sizes with minimum widths <code>500px</code>, <code>800px</code>, <code>950px</code> and <code>1025px</code> 
            respectively. Media queries are set in pixels to prevent modifications that may occur when the font size of the html body is modified which 
            may redefine the response of the content. There are only three utility classes based on these 5 steps which are <code>xs-1</code>, <code>xs-2</code> and 
            <code>xs-3</code> respectively although there is a slight ending utility class built upon the <code>xs-</code> utility classes. 
            and this is achieved by placing an <code>"s"</code> after the aforementioned classes. Hence, we have <code>xs-1s</code>, 
            <code>xs-2s</code> and <code>xs-3s</code> classes. The utility classes are discussed based on their responses on screen sizes. <br>
            <br>
            <style>
                table.calibri tr > th{
                    padding: 10px;
                    min-width: 20px;
                    background-color: rgba(var(--silver));
                    margin: 0;
                }
                table.calibri tr > td{
                    background-color: rgba(var(--silver-d));
                    padding: 4px;
                }

                table.calibri{
                    border-spacing: 10px; 
                    min-width: 60%;
                }
            </style>
            <table class="calibri" style="color:rgba(var(--orange-dd))">
                <tr class="" style="color:rgba(var(--olive))"> <th>Class</th> <th> <500px </th><th>>=500px</th><th>>=800px</th><th>>=950px</th><th>>=1025px</th></tr>
                <tr><th>xs-1</th><td>0% padding</td><td>0% padding</td><td>5% padding</td><td>10% padding</td><td>10% padding</td></tr>
                <tr><th>xs-2</th><td>0% padding</td><td>0% padding</td><td>10% padding</td><td>10% padding</td><td>10% padding</td></tr>
                <tr><th>xs-3</th><td>0% padding</td><td>0% padding</td><td>10% padding</td><td>10% padding</td><td>20% padding</td></tr>
                <tr><th>xs-1s</th><td>2% padding</td><td>0% padding</td><td>5% padding</td><td>10% padding</td><td>10% padding</td></tr>
                <tr><th>xs-2s</th><td>2% padding</td><td>0% padding</td><td>10% padding</td><td>10% padding</td><td>10% padding</td></tr>
                <tr><th>xs-3s</th><td>2% padding</td><td>0% padding</td><td>10% padding</td><td>10% padding</td><td>20% padding</td></tr>
            </table>

            <span class="form-field">
                
                From the above, we can see that for any "xs-" utility class, the minimum padding is set at <code>0%</code> unless the 
                class ends with an <code>"s"</code> which sets the minimum padding at 2% of the current screen size. 
                
            </span>
        </span>

    </div> <br>

    
    <div class="padd-x-4">

        <span class="font-em-d85">
            <div class="wid-fit c-olive font-em-1d5">Container Box Items</div>
            The <code>box</code> utilty class has the property of inline-block display type. It is is mostly used to achieve 
            fluid responsive paddings. Box items are naturally built to have responsive feature although they are not the main responsive classes.  
            While the <code>xs-</code> classes may have a swift response, the <code>box</code> classes have a smoother transition 
            that reflect an elasticity when page width is expanded. While <code>box</code> sets an inline-block element, <code>box-full</code> sets an inline-block element 
            at 100% width. The responsive nature is based on the <code>xs-</code> responsive utility classes which is discussed earlier. 
            A box element can be integerated with the responsive class by combining the <code>box</code> class with the <code>xs-</code> class 
            to give a <code>boxs-</code> utilty class in which any of the "screen" steps (i.e 1, 2 or 3) mentioned earlier can be applied on it. 
            For example, an element with a utility class <code>boxs-1</code> will have its display type as inline-block while its responsive feature 
            is maintained. Hence the following box utility classes are allowed 
            <span class="form-field">
                
                <code class="main">boxs-1</code>, <code class="main">boxs-2</code>,
                <code class="main">boxs-3</code>, <code class="main">boxs-1s</code>,
                <code class="main">boxs-2s</code>, <code class="main">boxs-3s</code>. By default, all responsive utility classes <code>boxs-</code> have an 100% width.
    
            </span>
        </span>

    </div> <br>

@template;