One Time Password with Segmentation Support in the Most Confidential System (OTPSec)

##### Introduction ##### 

One Time Password (OTP) is a password that valid for only one time login session or transaction, on computers or other devices. The most important advantage that is addressed by OTP is that, in contrast to static passwords, they are not vulnerable to replay attacks. The OTP service that I will implement is the OTP with segmentation support or OTPSec. OTPSec is the One Time Password service that send the OTP code to user emails by segmentation. For example, you would like to login to your system. The OTPSec will divide the OTP code into many parts depending on the emails that you have set in the service, and send each of code parts to those emails. What the important in this service that is different from any other OTP services is if you would like to login to the system with this service, you must have at least 2 reliable friends depending on the emails that you will set, then they need enter the part of OTP code in their emails in the OTP field of the system simultaneously to access the system. 

##### Objectives ##### 

- To implement a new OTP Service that is high security for the most confidential system such as the database system for ministry of defense or government. 

- To study how OTP works in the cryptography system.
