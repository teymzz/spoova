@template('docs.integerations.template.co.format')

    @title('Css Integerations - Widths')
    @style('build.css.tutorial:root:css')
    @style('build.css.headers:tutorial')
    
    <div class="padd-x-4"> <br>

        <div class="flex-in midv font-em-2 bc-silver rad-4 calibri">
            <a href="@domurl('docs/other-features/css')"><div class="fb-6 pxs-20 c-grey bc-silver-d pxv-10 mxr-10">Css</div></a>
            <div class="c-orange-dd">utility classes</div>
        </div><br>

<span class="font-em-d87">
    <div class="wid-fit c-olive font-em-1d5">Element widths</div>
    There are four basic utilty classes that can be used to specify content element widths. These 
    classes are listed below: <br><br>
    <span class="form-field">
        
        <code class="main">wid-full</code> - 100% width<br>
        <code class="main">wid-min</code> - sets element width to min-content<br>
        <code class="main">wid-max</code> - sets element width to max-content<br>
        <code class="main">wid-fit</code> - sets element width to fit-content<br>
        <code class="main">wid-i</code> - inherit parent width property <br>

    </span><br>
    Although, the <code>wid-full</code> is specially designed to set element width to 100%, the directive 
    <code>-full</code> may also be allowed in some display items like flex items and boxes as though it is not
    applicable in all cases. Another utility class that can be used to set an element's width is the  <code>vx-full</code> class.
    It sets the view width of any content (i.e relative to the screen width). Other width setting classes are listed below: <br>
    <br>
    <span class="form-field">
        
        <code class="main">wper-50</code> - sets width at 50%<br>
        <code class="main">full-width</code> - sets element width at 100%<br>
        <code class="main">ll-full</code> - sets element width at 100%<br>

    </span>    <br>
    The <code>full-width</code> and <code>ll-full</code> have a much higher effect when applied on elements than <code>wid-full</code> 
    though they are not strictly defined. 
</span>

    </div> <br>

    <div class="padd-x-4">

        <span class="font-em-d85">
            <div class="wid-fit c-olive font-em-1d5">Element heights</div>
            Heights are mostly set based on the screen height. The two classes <code>vh-</code> and <code>vhm-</code> both measures the height of element 
            using the <code>vh</code> unit. While the <code>vh-</code> classes measure based on height, the <code>vhm-</code> classes measures based on minimum height.
            Heights range from the vh-80 to vh-90 utility classes. 
            The vh-80 series include <code>vh-80</code>, <code>vh-85</code> and <code>vh-87</code> utility classes while the vh-90 series include <code>vh-90</code>, <code>vh-95</code>,
            and <code>vh-97</code> classes. This same logic is applied for the <code>vhm-</code> series. The digits on these classes identifies the vertical height (vh) they give. '
            There are other classes that measures heights based on percentage. An example is the <code>h-full</code> class which sets the height of element to 100%.
        </span>

    </div> <br>
@template;