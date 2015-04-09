<?php 
    //get browser
    $u_agent = $_SERVER['HTTP_USER_AGENT']; 
    $chrome = false; 
    if(preg_match('/Chrome/i',$u_agent)) { 
        $chrome = true; 
    }
?>


        <?php if(!isset($dealer)): ?>

            <h2>No Results.</h2>
        
        <?php else: ?>

            <?php /* * * DEALER DETAILS HEADER * * */ ?>
            
                <?php

                $zip = (!empty($dealer['Dealer']['zip'])) ? $dealer['Dealer']['zip'] : '';
                $city = (!empty($dealer['Dealer']['city'])) ? ucwords(strtolower($dealer['Dealer']['city'])) : '';

                ?>

                <div id="dealer_details_header" class="cols w960">
                    <h1><?php echo strtoupper($city); ?> HOT TUB DEALER</h1>
                    <a id="dl-print" href="javascript:window.print()" class="teal-button" >Print Page</a>
                    <?php /* Insert breadcrumb */ ?>
                </div>

            <?php /* * * DEALER DETAILS THREE COLS * * */ ?>
                <div id="dealer_details_3col" class="cols">
                
                    <?php /* IMAGE ROTATOR */ ?>
                    <div id="dealer_details_3col_img" class="col w320">
                        <div class="dealer-img-contain">
                            <?php 
                            if($dealer['Image']) {
                                echo '<ul id="slider1">';
                                foreach($dealer['Image'] as $i){
                                    echo '<li>' . $this->Image->resize('/files/dealer_imgs/'.$i['dealer_id'].'/store/'.$i['path'], 304, 317, array('class' => 'dealerimg')) . '</li>';
                                }
                                echo '</ul>';
                            }
                            else {?>
                                <ul id="slider1"><li><img src="/wp-content/themes/sundance/images/dealer-locator/default-detail-img.jpg" width="304" height="317"/></li></ul>
                            <?php } ?>
                        </div>
                    </div>

                    <?php /* DEALER DETAILS */ ?>
                    <div id="dealer_details_3col_details" class="col w320">
                        <?php // dealer name ?>
                        <h2><?php echo ucwords(strtolower($dealer['Dealer']['name'])); ?></h2>
                        <?php // dealer address ?>
                        <h3>Address</h3>
                        <p>
                            <?php
                            echo $dealer['Dealer']['address1'];
                            if(!empty($dealer['Dealer']['address2'])) {
                                echo '<br>'.$dealer['Dealer']['address2'];
                            }
                            if(!empty($dealer['Dealer']['city'])) {
                                echo '<br>'.$dealer['Dealer']['city'];
                            }
                            if(!empty($dealer['State']['abbreviation'])) {
                                echo ', '.$dealer["State"]["abbreviation"];
                            }
                            if(!empty($dealer['Dealer']['zip'])) {
                                echo ' '.$dealer["Dealer"]["zip"];
                            }
                            ?>
                        </p>
                        <?php // dealer phone number ?>
                        <h3>Phone</h3>
                        <p>
                            <?php if(!empty($dealer['Dealer']['phone'])):
                                echo $dealer['Dealer']['phone'];
                                ?>
                                <a class="teal-button" onclick="show_sms()">Send to Phone</a>
                                <?php
                            endif; ?>
                        </p>
                        <?php // dealer hours ?>

                        <?php //dealer email ?>
                            <?php if(!empty($dealer['Dealer']['email'])) {
                                echo '<a id="icon-email-dealer" class="lt" href="mailto:'.$dealer['Dealer']['email'].'?subject=SundanceSpas.com Information Request"><u>Email dealer</u></a>';
                            } ?>
                        <?php // dealer website ?>
                            <?php if(!empty($dealer['Dealer']['website'])) {
                                echo '<a id="icon-dealer-website" class="rt" href="'.$this->webroot.'omniture/'.$dealer['Dealer']['id'].'/" title="'.ucwords(strtolower($dealer['Dealer']['name'])).'" target="_blank" rel="nofollow">Dealer\'s Website</a>';
                            } ?>
                    </div>

                    <?php /* DEALER MAP */ ?>
                    <div id="dealer_details_3col_map" class="col w320">
                        <div id="map-canvas" class="dealer-map">
                            <iframe src="https://www.google.com/maps/embed?pb=!1m14!1m8!1m3!1d3352.2523931932833!2d-117.13489330000002!3d32.83856840000001!3m2!1i1024!2i768!4f13.1!3m3!1m2!1s0x80dbffaef8d8ac21%3A0x75d02d21a7300244!2s5710+Kearny+Villa+Rd%2C+San+Diego%2C+CA+92123!5e0!3m2!1sen!2sus!4v1408659604530" width="320" height="317" frameborder="0" style="border:0"></iframe>
                        </div>
                    </div>
                </div>

            <?php /* * * DEALER DETAILS TWO COLS * * */ ?>
                <div id="dealer_details_2col" class="cols">
                    <?php /* VIDEO */ ?>
                    <div id="dealer_details_2col_video">
                        <iframe width="459" height="283" src="//www.youtube.com/embed/aDETNR5oAgg" frameborder="0" allowfullscreen></iframe>
                    </div>
                    <?php /* TESTIMONIALS */ ?>
                    <div id="dealer_details_2col_testimonials">
                        <h3>Testimonials</h3>
                        <ul id="slider2">
                        <?php foreach($dealer['Quote'] as $q){?>
                            <li>
                                <span class="test-quot lt">&ldquo;</span>
                                <span id="testimonial-container">
                                    <p class="dealertest">
                                        <?php echo $q['quote'];?>
                                        <br /><br />
                                        <em>- <?php echo $q['name'];?></em>
                                    </p>
                                </span>
                                <span class="test-quot rt">&rdquo;</span>
                            </li>
                        <?php }?>
                            <?php /* DEMO TESTIMONIALS */ ?>
                                                <li>
                                                    <span class="test-quot lt">&ldquo;</span>
                                                    <span id="testimonial-container">
                                                        <p class="dealertest">
                                                            This is a demo testimonial
                                                            <br /><br />
                                                            <em>- Admin Aaron</em>
                                                        </p>
                                                    </span>
                                                    <span class="test-quot rt">&rdquo;</span>
                                                </li>
                                                <li>
                                                    <span class="test-quot lt">&ldquo;</span>
                                                    <span id="testimonial-container">
                                                        <p class="dealertest">
                                                            These demo testimonials will need to be deleted before this thing is pushed live
                                                            <br /><br />
                                                            <em>- Programmer Smith</em>
                                                        </p>
                                                    </span>
                                                    <span class="test-quot rt">&rdquo;</span>
                                                </li>
                                                <li>
                                                    <span class="test-quot lt">&ldquo;</span>
                                                    <span id="testimonial-container">
                                                        <p class="dealertest">
                                                            But in the meantime the point of these is to show an example of how the text will rotate once there is text. Question tho, what is going to be the default value?
                                                            <br /><br />
                                                            <em>- Guy</em>
                                                        </p>
                                                    </span>
                                                    <span class="test-quot rt">&rdquo;</span>
                                                </li>
                            <?php // end demo testimonials ?>
                        </ul>
                    </div>
                </div>

            <?php /* * * DEALER DETAILS MAIN AREA * * */ ?>
                <div id="dealer_details_main" class="cols">
                    <?php /* TABBED SECTION */ ?>
                    <div id="dealer_details_main_tabbed" class="col w640">
                        <ul class="header">
                            <li tab="main1" class="active">About</li>
                            <li tab="main2">Staff</li>
                            <li tab="main3">Services</li>
                        </ul>
                        <div class="tab-area active tab-main1">This will be the about area</div>
                        <div class="tab-area tab-main2">Staff goes here</div>
                        <div class="tab-area tab-main3">These are our services</div>
                    </div>
                    <?php /* SIDEBAR */ ?>
                    <div id="dealer_details_main_sidebar" class="col w320">
                        <div class="header">Discover More</div>
                        <div class="sidebar">
                            <img src="/wp-content/themes/sundance/images/dealer-locator/dl-details-checklist.jpg" />
                            <a class="teal-button" href="#">Dealer Visit Checklist</a>
                        </div>
                        <div class="sidebar">
                            <img src="/wp-content/themes/sundance/images/dealer-locator/dl-details-get-pricing.jpg" />
                            <a class="teal-button" href="/get-a-quote/">Get Pricing</a>
                        </div>
                        <div class="sidebar">
                            <img src="/wp-content/themes/sundance/images/dealer-locator/dl-details-tradein.jpg" />
                            <a class="teal-button" href="/trade-in-value/">Trade-In</a>
                        </div>
                        <div class="sidebar">
                            <img src="/wp-content/themes/sundance/images/dealer-locator/dl-details-10yrwarranty.jpg" />
                            <p>10-Year Warranty</p>
                        </div>
                    </div>
                </div>


            <?php // DEBUG ?>
            <?php echo '<pre style="display: none;">'; var_dump($dealer); echo '</pre>'; ?>

            <?php /* SEND TO PHONE SMS */ ?>
            <div id="sms-container" >
                <div id="sms-form" >
                    <h3>Send to Phone</h3>
                    <form action="#" method="post" id="sms-fields" name="send-message-form" >
                        <label for="sms-carrier">Select Your Mobile Carrier</label>
                        <select id="sms-carrier" name="sms-carrier">
                            <option value="">Choose from available carriers</option>
                            <optgroup>
                                <option value="txt.att.net">AT&T</option>
                                <option value="sms.mycricket.com">Cricket</option>
                                <option value="mymetropcs.com">MetroPCS</option>
                                <option value="messaging.sprintpcs.com">Sprint</option>
                                <option value="tmomail.net">T-Mobile</option>
                                <option value="txt.att.net">TracFone</option>
                                <option value="email.uscc.net">U.S. Cellular</option>
                                <option value="vtext.com">Verizon</option>
                                <option value="vmobl.com">Virgin Mobile</option>
                            </optgroup>
                        </select>
                        <br />
                        <label for="sms-phonenumber">Enter your mobile number</label>
                        <input type="text" id="sms-phonenumber" class="phonenumber" name="sms-phonenumber" placeholder="Phone Number"/>
                        <br />
                        <input type="hidden" name="action" value="sms_dealer_email" />
                        <input type="submit" id="submit-sms" class="teal-button" name="submit-sms" value="Send details to my phone" />
                    </form>
                    <a class="close-popup">X</a>
                </div>
                <div id="sms-form-success">
                    <h3>Thank you!</h3><p>Your Dealer information is on its way.</p>
                    <a class="teal-button">Close</a>
                </div>
            </div>

        <?php endif; ?>


        <?php //echo $this->renderElement('seotxt'); ?>
    

        <?php $_SESSION['inUSCA'] = $inUSCA; ?>

<script>
    /*!
     * jQuery Cycle Lite Plugin
     * http://malsup.com/jquery/cycle/lite/
     * Copyright (c) 2008-2012 M. Alsup
     * Version: 1.7 (20-FEB-2013)
     * Dual licensed under the MIT and GPL licenses:
     * http://www.opensource.org/licenses/mit-license.php
     * http://www.gnu.org/licenses/gpl.html
     * Requires: jQuery v1.3.2 or later
     */
    ;(function($) {
    "use strict";

    var ver = 'Lite-1.7';
    var msie = /MSIE/.test(navigator.userAgent);

    $.fn.cycle = function(options) {
        return this.each(function() {
            options = options || {};
            
            if (this.cycleTimeout) 
                clearTimeout(this.cycleTimeout);

            this.cycleTimeout = 0;
            this.cyclePause = 0;
            
            var $cont = $(this);
            var $slides = options.slideExpr ? $(options.slideExpr, this) : $cont.children();
            var els = $slides.get();
            if (els.length < 2) {
                if (window.console)
                    console.log('terminating; too few slides: ' + els.length);
                return; // don't bother
            }

            // support metadata plugin (v1.0 and v2.0)
            var opts = $.extend({}, $.fn.cycle.defaults, options || {}, $.metadata ? $cont.metadata() : $.meta ? $cont.data() : {});
            var meta = $.isFunction($cont.data) ? $cont.data(opts.metaAttr) : null;
            if (meta)
                opts = $.extend(opts, meta);
                
            opts.before = opts.before ? [opts.before] : [];
            opts.after = opts.after ? [opts.after] : [];
            opts.after.unshift(function(){ opts.busy=0; });
                
            // allow shorthand overrides of width, height and timeout
            var cls = this.className;
            opts.width = parseInt((cls.match(/w:(\d+)/)||[])[1], 10) || opts.width;
            opts.height = parseInt((cls.match(/h:(\d+)/)||[])[1], 10) || opts.height;
            opts.timeout = parseInt((cls.match(/t:(\d+)/)||[])[1], 10) || opts.timeout;

            if ($cont.css('position') == 'static') 
                $cont.css('position', 'relative');
            if (opts.width) 
                $cont.width(opts.width);
            if (opts.height && opts.height != 'auto') 
                $cont.height(opts.height);

            var first = 0;
            $slides.css({position: 'absolute', top:0}).each(function(i) {
                $(this).css('z-index', els.length-i);
            });
            
            $(els[first]).css('opacity',1).show(); // opacity bit needed to handle reinit case
            if (msie) 
                els[first].style.removeAttribute('filter');

            if (opts.fit && opts.width) 
                $slides.width(opts.width);
            if (opts.fit && opts.height && opts.height != 'auto') 
                $slides.height(opts.height);
            if (opts.pause) 
                $cont.hover(function(){this.cyclePause=1;}, function(){this.cyclePause=0;});

            var txFn = $.fn.cycle.transitions[opts.fx];
            if (txFn)
                txFn($cont, $slides, opts);
            
            $slides.each(function() {
                var $el = $(this);
                this.cycleH = (opts.fit && opts.height) ? opts.height : $el.height();
                this.cycleW = (opts.fit && opts.width) ? opts.width : $el.width();
            });

            if (opts.cssFirst)
                $($slides[first]).css(opts.cssFirst);

            if (opts.timeout) {
                // ensure that timeout and speed settings are sane
                if (opts.speed.constructor == String)
                    opts.speed = {slow: 600, fast: 200}[opts.speed] || 400;
                if (!opts.sync)
                    opts.speed = opts.speed / 2;
                while((opts.timeout - opts.speed) < 250)
                    opts.timeout += opts.speed;
            }
            opts.speedIn = opts.speed;
            opts.speedOut = opts.speed;

            opts.slideCount = els.length;
            opts.currSlide = first;
            opts.nextSlide = 1;

            // fire artificial events
            var e0 = $slides[first];
            if (opts.before.length)
                opts.before[0].apply(e0, [e0, e0, opts, true]);
            if (opts.after.length > 1)
                opts.after[1].apply(e0, [e0, e0, opts, true]);
            
            if (opts.click && !opts.next)
                opts.next = opts.click;
            if (opts.next)
                $(opts.next).unbind('click.cycle').bind('click.cycle', function(){return advance(els,opts,opts.rev?-1:1);});
            if (opts.prev)
                $(opts.prev).unbind('click.cycle').bind('click.cycle', function(){return advance(els,opts,opts.rev?1:-1);});

            if (opts.timeout)
                this.cycleTimeout = setTimeout(function() {
                    go(els,opts,0,!opts.rev);
                }, opts.timeout + (opts.delay||0));
        });
    };

    function go(els, opts, manual, fwd) {
        if (opts.busy) 
            return;
        var p = els[0].parentNode, curr = els[opts.currSlide], next = els[opts.nextSlide];
        if (p.cycleTimeout === 0 && !manual) 
            return;

        if (manual || !p.cyclePause) {
            if (opts.before.length)
                $.each(opts.before, function(i,o) { o.apply(next, [curr, next, opts, fwd]); });
            var after = function() {
                if (msie)
                    this.style.removeAttribute('filter');
                $.each(opts.after, function(i,o) { o.apply(next, [curr, next, opts, fwd]); });
                queueNext(opts);
            };

            if (opts.nextSlide != opts.currSlide) {
                opts.busy = 1;
                $.fn.cycle.custom(curr, next, opts, after);
            }
            var roll = (opts.nextSlide + 1) == els.length;
            opts.nextSlide = roll ? 0 : opts.nextSlide+1;
            opts.currSlide = roll ? els.length-1 : opts.nextSlide-1;
        } else {
          queueNext(opts);
        }

        function queueNext(opts) {
            if (opts.timeout)
                p.cycleTimeout = setTimeout(function() { go(els,opts,0,!opts.rev); }, opts.timeout);
        }
    }

    // advance slide forward or back
    function advance(els, opts, val) {
        var p = els[0].parentNode, timeout = p.cycleTimeout;
        if (timeout) {
            clearTimeout(timeout);
            p.cycleTimeout = 0;
        }
        opts.nextSlide = opts.currSlide + val;
        if (opts.nextSlide < 0) {
            opts.nextSlide = els.length - 1;
        }
        else if (opts.nextSlide >= els.length) {
            opts.nextSlide = 0;
        }
        go(els, opts, 1, val>=0);
        return false;
    }

    $.fn.cycle.custom = function(curr, next, opts, cb) {
        var $l = $(curr), $n = $(next);
        $n.css(opts.cssBefore);
        var fn = function() {$n.animate(opts.animIn, opts.speedIn, opts.easeIn, cb);};
        $l.animate(opts.animOut, opts.speedOut, opts.easeOut, function() {
            $l.css(opts.cssAfter);
            if (!opts.sync)
                fn();
        });
        if (opts.sync)
            fn();
    };

    $.fn.cycle.transitions = {
        fade: function($cont, $slides, opts) {
            $slides.not(':eq(0)').hide();
            opts.cssBefore = { opacity: 0, display: 'block' };
            opts.cssAfter  = { display: 'none' };
            opts.animOut = { opacity: 0 };
            opts.animIn = { opacity: 1 };
        },
        fadeout: function($cont, $slides, opts) {
            opts.before.push(function(curr,next,opts,fwd) {
                $(curr).css('zIndex',opts.slideCount + (fwd === true ? 1 : 0));
                $(next).css('zIndex',opts.slideCount + (fwd === true ? 0 : 1));
            });
            $slides.not(':eq(0)').hide();
            opts.cssBefore = { opacity: 1, display: 'block', zIndex: 1 };
            opts.cssAfter  = { display: 'none', zIndex: 0 };
            opts.animOut = { opacity: 0 };
            opts.animIn = { opacity: 1 };
        }
    };

    $.fn.cycle.ver = function() { return ver; };

    // @see: http://malsup.com/jquery/cycle/lite/
    $.fn.cycle.defaults = {
        animIn:        {},
        animOut:       {},
        fx:           'fade',
        after:         null,
        before:        null,
        cssBefore:     {},
        cssAfter:      {},
        delay:         0,
        fit:           0,
        height:       'auto',
        metaAttr:     'cycle',
        next:          null,
        pause:         false,
        prev:          null,
        speed:         1000,
        slideExpr:     null,
        sync:          true,
        timeout:       4000
    };

    })(jQuery);
</script>

<script>
function show_sms() {
    jQuery('#sms-form-success').hide();
    jQuery('#sms-carrier').val("");
    jQuery('#sms-phonenumber').val("");
    jQuery('#sms-container').show('slow');
    jQuery('#sms-form').show();
}

(function($){

        // tab controller
        $('li[tab*="main"]').bind('click', function(){
            var tab = $(this).attr('tab');
            if(!$(this).hasClass('active')){
                $(this).addClass('active').siblings('.active').removeClass('active');
                $('div.tab-area.active').removeClass('active');
                $('div.tab-area.tab-' + tab).addClass('active');
            }
        });

        // Image Rotator action
        $('#slider1').cycle({
            fx: 'fade', // here change effect to blindX, blindY, blindZ etc 
            speed: 'slow', 
            timeout: 3000 
        });

        // Testimonial rotator action
        $('#slider2').cycle({
            fx: 'fade', // here change effect to blindX, blindY, blindZ etc 
            speed: 'slow', 
            timeout: 5000 
        });

        
        $('.close-popup').click( function() {
            $('#sms-container').hide('normal');
        });

        // SMS pop-up control
        $(document).bind('mouseup touchstart', function(e){
            var container = $('#sms-form');
            if (!container.is(e.target) // if the target of the click isn't the container...
                && container.has(e.target).length === 0) // ... nor a descendant of the container
            {
                $('#sms-container').hide('slow');
            }
        });
    
        // submit for SMS form
        $('form[name=send-message-form]').submit( function() {
            var canSubmit = true;
            var smsNumber = $('#sms-phonenumber').val();
            smsNumber = smsNumber.replace(/\D/g,'');
            var smsCarrier = $('#sms-carrier').val();

            if ( smsNumber == '' ) { canSubmit = false; }
            if ( smsCarrier == '' ) { canSubmit = false; }

            var emailToVal = smsNumber + '@' + smsCarrier;
            var subjectVal = '<?php echo addslashes($dealer['Dealer']['name']); ?>';
            var messageVal = "Address: <?php echo $dealer['Dealer']['address1'].(!empty($dealer['Dealer']['address2']) ? ', '.$dealer['Dealer']['address2'] : '').', '.$dealer['Dealer']['city'].', '.$dealer['State']['abbreviation'].' '.$dealer['Dealer']['zip']; ?>" + "\n" + "Phone: <?php echo $dealer['Dealer']['phone'] ?>" + "\n" + "Website: <?php echo $dealer['Dealer']['website']; ?>";
            var data = { action: 'sms_dealer_email', emailTo: emailToVal, subject: subjectVal, message: messageVal };

            if ( canSubmit == true ) {
                $.post(
                    "/wp-admin/admin-ajax.php",
                    data,
                    function(response) {
                        $('#sms-form').hide();
                        $("#sms-form-success").show("normal");
                    }
                );
                //_gaq.push(['_trackEvent', 'DealerLocator', 'Send-to-phone']);
            }
            return false;
        });

})(jQuery);
</script>