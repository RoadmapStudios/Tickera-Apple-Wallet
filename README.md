# tickera-apple-wallet
Apple &amp; Android Wallet Add-on for Tickera

With this amazing add-on, you can now enable Apple and Android Wallet for your customers. Users will get the option to save the e-ticket as an Apple Pass or Android Pass after purchasing a ticket. They will also see this in their email notification. The add-on automatically detects the user's device (iOS/Android) and displays the correct download link.

This wordpress plugin is possible thanks to Tickera and the Passbook PHP library of Eymen Gunay:
https://github.com/eymengunay/php-passbook


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
7. Once you have downloaded the Apple iPhone certificate from Apple, export it to the P12 certificate format.

**To do this on Mac OS:**

1. Open the Keychain Access application (in the Applications/Utilities folder).
2. If you have not already added the certificate to Keychain, select File > Import. Then navigate to the certificate file (the .cer file) you obtained from Apple.
3. Select the Keys category in Keychain Access.
4. Select the private key associated with your iPhone Development Certificate. The private key is identified by the iPhone Developer: <First Name> <Last Name> public certificate that is paired with it.
5. Select File > Export Items.
6. Save your key in the Personal Information Exchange (.p12) file format.
7. You will be prompted to create a password that is used when you attempt to import this key on another computer.

**on Windows:**

1. Convert the developer certificate file you receive from Apple into a PEM certificate file. Run the following command-line statement from the OpenSSL bin directory:

```
openssl x509 -in developer_identity.cer -inform DER -out developer_identity.pem -outform PEM
```

2. If you are using the private key from the keychain on a Mac computer, convert it into a PEM key:

```
openssl pkcs12 -nocerts -in mykey.p12 -out mykey.pem
```

3. You can now generate a valid P12 file, based on the key and the PEM version of the iPhone developer certificate:

```
openssl pkcs12 -export -inkey mykey.key -in developer_identity.pem -out iphone_dev.p12
```

If you are using a key from the Mac OS keychain, use the PEM version you generated in the previous step. Otherwise, use the OpenSSL key you generated earlier (on Windows).

### Support
For any functional support, please read the documentation first. If you run into any technical issue with this addon, please deactivate all non-essential plugins to ensure there is no plugin conflict. After this, please check the above steps again, most users create the certificate wrong or have expired certificates in their Apple account. If none of these apply to you, please open an issue here in github. 
*Important: you may need to install WP Add Mime Types plugin if you are unable to download the passes. Please check the documentation.
