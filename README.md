# tickera-apple-wallet
Apple &amp; Android Wallet Add-on for Tickera

With this amazing add-on, you can now enable Apple and Android Wallet for your customers. Users will get the option to save the e-ticket as an Apple Pass or Android Pass after purchasing a ticket. They will also see this in their email notification. The add-on automatically detects the user's device (iOS/Android) and displays the correct download link.

## How to install
*Android: no configuration needed for Android. Below instructions is only for Apple Pass.
*Requirement: Mac with latest stable popular browser.
1. Upload the zip of this plugin via WordPress Plugins > New Plugin
2. Go to Tickera Event's Settings and click on Apple Wallet
3. Choose your QR Code Type, upload your small icon in PNG and fill in the text fields for your Pass styling.
*Now go to developer.apple.com and login
4. Team Identifier: this is your Apple Team ID, you can find this in your URL when you are logged in in developer.apple.com
5. To register a pass type identifier, do the following:
   - In Certificates, Identifiers & Profiles, select Identifiers.
   - Under Identifiers, select Pass Type IDs.
   - Click the plus (+) button.
   - Enter the description and pass type identifier, and click Submit.
6. WWRD file: Apple’s World Wide Developer Relations (WWDR) certificate is available from Apple at http://developer.apple.com/certificationauthority/AppleWWDRCA.cer. You will have to add this to your Keychain Access and export it in .pem format to use it with the library. The WWDR certificate links your development certificate to Apple, completing the trust chain for your application.
7. P12 file: Kieron Gurner from Calvium.com provides a detailled and simple instructions on this file> https://calvium.com/how-to-make-a-p12-file/

### Support
For any functional support, please contact Tickera support team. If you run into any technical issue with this addon, please deactivate all non-essential plugins to ensure there is no plugin conflict. After this, please check the above steps again, most users create the certificate wrong or have expired certificates in their Apple account. If none of these apply to you, please open an issue here in github. 
