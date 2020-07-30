</table>
<!-- Email Body : END -->
           <!-- Email Footer : BEGIN -->
            <table role="presentation" cellspacing="0" cellpadding="0" border="0" align="center" width="100%" style="max-width: 680px; font-family: sans-serif; color: #888888; font-size: 12px; line-height: 140%;">
                <tr>
                    <td style="padding: 40px 10px; width: 100%; font-family: sans-serif; font-size: 12px; line-height: 140%; text-align: center; color: #888888;" class="x-gmail-data-detectors">
                        
                        <br><br>
                        {{ $this->config->item('email_company_name', 'ion_auth') }}<br>{{ $this->config->item('email_company_address', 'ion_auth') }}<br>{{ $this->config->item('email_company_phone', 'ion_auth') }}
                        <br><br>
                    </td>
                </tr>
            </table>
            <!-- Email Footer : END -->

            <!--[if mso]>
            </td>
            </tr>
            </table>
            <![endif]-->
        </div>

    </center>
</body>
</html>