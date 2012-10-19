<!DOCTYPE html>
<html xmlns="http://www.w3.org/1999/xhtml" lang="en" xml:lang="en">
    <head>
        <meta charset="utf-8">
            <title>Desktop/Mobile detection page</title>        
            <meta name="viewport" content="width=device-width,minimum-scale=1.0,maximum-scale=1.0,user-scalable=no" />
            <style type="text/css">
                html {
                    font-size: 100%;
                    -webkit-text-size-adjust: 100%;
                    -ms-text-size-adjust: 100%;
                }   
                body {
                    margin: 0;
                    padding: 0 1em;
                    font-family: "Helvetica Neue", Helvetica, Arial, sans-serif;
                    font-size: 100%;
                    line-height: 1.2em;
                    color: #333333;
                    background-color: #ffffff;
                }
                a {
                    color: #0088cc;
                    text-decoration: underline;
                }
                a:hover {
                    color: #005580;
                    text-decoration: underline;
                }
                hr { border: 1px dotted #cccccc; }

                .desktop { background-color:blue; color:white; } 
                .tablet { background-color:yellow; color:black; }
                .mobile,.true { background-color:green; color:white; }
                .randomcrap { background:#eee; color:#666; }

                .sendDataButton {
                    border-radius: 1em;
                    -moz-border-radius: 1em;
                    -webkit-border-radius: 1em;
                    padding:0.5em 1em;
                    cursor: pointer;
                }

                .sendDataButton.yes {
                    color:white;
                    border: 1px solid #56A00E;
                    background: #74B042;
                    font-weight: bold;
                    color: #ffffff;
                    text-shadow: 0 1px 0 #335413;
                    background-image: -webkit-gradient(linear, left top, left bottom, from( #74B042 ), to( #56A00E )); /* Saf4+, Chrome */
                    background-image: -webkit-linear-gradient( #74B042 , #56A00E ); /* Chrome 10+, Saf5.1+ */
                    background-image:    -moz-linear-gradient( #74B042 , #56A00E ); /* FF3.6 */
                    background-image:     -ms-linear-gradient( #74B042 , #56A00E ); /* IE10 */
                    background-image:      -o-linear-gradient( #74B042 , #56A00E ); /* Opera 11.10+ */
                    background-image:         linear-gradient( #74B042 , #56A00E );
                }

                .sendDataButton.no {
                    color:white;
                    border: 1px solid #cd2c24;
                    background: green;
                    font-weight: bold;
                    color: #ffffff;
                    text-shadow: 0 1px 0 #444444;
                    background-image: -webkit-gradient(linear, left top, left bottom, from( #e13027 ), to( #b82720 )); /* Saf4+, Chrome */
                    background-image: -webkit-linear-gradient( #e13027 , #b82720 ); /* Chrome 10+, Saf5.1+ */
                    background-image:    -moz-linear-gradient( #e13027 , #b82720 ); /* FF3.6 */
                    background-image:     -ms-linear-gradient( #e13027 , #b82720 ); /* IE10 */
                    background-image:      -o-linear-gradient( #e13027 , #b82720 ); /* Opera 11.10+ */
                    background-image:         linear-gradient( #e13027 , #b82720 );
                }


            </style>
    </head>
    <body>
        <section>
            <header>
                <h1><a href="http://code.google.com/p/php-mobile-detect/">Mobile_Detect</a></h1>
                <p>Mobile_Detect is a lightweight PHP class for detecting mobile devices. It uses the User-Agent string combined with specific HTTP headers to detect the mobile environment.</p>
            </header>
            <?php
            // Check for mobile device.
            require_once 'lib/php/Mobile_Detect/Mobile_Detect.php';
            $detect = new Mobile_Detect();
            $layout = ($detect->isMobile() ? ($detect->isTablet() ? 'tablet' : 'mobile') : 'desktop');
            ?>            
        </section>
        <hr>
            <section id="deviceQuestion">
                <h1>Is your device really a <em><?php echo $layout; ?></em>?</h1>
                <p>Please help us improve the mobile detection by choosing the correct answer.</p>
                <p class="<?php echo $layout; ?>">This is <b><?php echo $layout; ?></b>. Your UA is <b><?php echo htmlentities($_SERVER['HTTP_USER_AGENT']); ?></b></p>
            </section>
            <hr>
                <section>
                    <header>
                        <h1>Supported methods tests</h1>
                        <p>Please report any bugs to the <a href="http://code.google.com/p/php-mobile-detect/issues/list">issue list</a> specifying the user agent below.</p>
                    </header>
                    <table>
                        <tbody>
                            <tr>
                                <th colspan="2">Basic detection methods</th>
                            </tr>
                            <tr>
                                <td>isMobile()</td><td <?php $check = $detect->isMobile();
            if ($check): ?>class="true"<?php endif; ?>><?php var_dump($check); ?></td>
                            </tr>
                            <tr>
                                <td>isTablet()</td><td <?php $check = $detect->isTablet();
            if ($check): ?>class="true"<?php endif; ?>><?php var_dump($check); ?></td>
                            </tr>
                        </tbody>
                        <tbody>
                            <tr>
                                <th colspan="2">Custom detection methods</th>
                            </tr>
                            <?php
                            foreach ($detect->getRules() as $name => $regex):
                                $check = $detect->{'is' . $name}();
                                ?>
                                <tr>
                                    <td>is<?php echo $name; ?>()</td>
                                    <td <?php if ($check): ?>class="true"<?php endif; ?>><?php var_dump($check); ?></td>
                                </tr>
<?php endforeach; ?>
                        </tbody>
                    </table>
                </section>  

                <section>
                    <header>
                        <h1>Other tests</h1>
                    </header>

                    <table>
                        <tr>
                            <td>isiphone()</td>
                            <td><?php echo var_dump($detect->isiphone()); ?></td>
                        </tr>		
                        <tr>
                            <td>isIphone()</td>
                            <td><?php echo var_dump($detect->isIphone()); ?></td>
                        </tr>  
                        <tr>
                            <td>istablet()</td>
                            <td><?php echo var_dump($detect->istablet()); ?></td>
                        </tr>
                        <tr>
                            <td>isIOS()</td>
                            <td><?php echo var_dump($detect->isIOS()); ?></td>
                        </tr>		
                        <tr>
                            <td>isWhateverYouWant()</td>
                            <td class="randomcrap"><?php echo var_dump($detect->isWhateverYouWant()); ?></td>
                        </tr>		
                    </table>

                </section>


                <footer>
                    <p>Copyright &copy; <?php echo date('Y'); ?></p>
                </footer>
                </body>
                </html>
