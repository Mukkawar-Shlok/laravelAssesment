<p align="center"><a href="https://laravel.com" target="_blank"><img src="https://raw.githubusercontent.com/laravel/art/master/logo-lockup/5%20SVG/2%20CMYK/1%20Full%20Color/laravel-logolockup-cmyk-red.svg" width="400" alt="Laravel Logo"></a></p>

<p align="center">
<a href="https://github.com/laravel/framework/actions"><img src="https://github.com/laravel/framework/workflows/tests/badge.svg" alt="Build Status"></a>
<a href="https://packagist.org/packages/laravel/framework"><img src="https://img.shields.io/packagist/dt/laravel/framework" alt="Total Downloads"></a>
<a href="https://packagist.org/packages/laravel/framework"><img src="https://img.shields.io/packagist/v/laravel/framework" alt="Latest Stable Version"></a>
<a href="https://packagist.org/packages/laravel/framework"><img src="https://img.shields.io/packagist/l/laravel/framework" alt="License"></a>
</p>

## About Laravel

Laravel is a web application framework with expressive, elegant syntax. We believe development must be an enjoyable and creative experience to be truly fulfilling. Laravel takes the pain out of development by easing common tasks used in many web projects, such as:


## Deployment On Forge with AwsEC2
* Sign up for an account on Forge.
* Connect your Forge account with GitHub.(Authorize github to connect with your repository)
  ![Connect with GitHub](https://github.com/user-attachments/assets/11e406f5-b7b2-47d2-b231-3503272f7f1b)
* Select your service provider(I will be using Aws)
  ![image](https://github.com/user-attachments/assets/edf4f84b-85c2-48f0-acb9-f0e6cc45bed6)
* From here on there will be instructions for aws ec2 settings for other provides you can take a look in to this [documentation](https://forge.laravel.com/docs/servers/providers.html)
* Now go to IAM dashboard of Aws.
  ![image](https://github.com/user-attachments/assets/887604ab-8fb8-4392-bdd3-24a8c179366e)
* Go inside users.
  ![image](https://github.com/user-attachments/assets/8c576821-0993-444e-b98e-78f963dbede1)
* Click on add a new user for this project.
* For giving required policies as explained in document the application AmazonEC2FullAccess and AmazonVPCFullAccess, we need to create a group which have this two policies.
* Or you could apply those polices to that user directly by choosing attach policies directly.
  ![image](https://github.com/user-attachments/assets/d0dcc512-fc5f-41d1-a805-02a6bdbd9027)
* The permission summary should look like this if you apply that directly.
  ![image](https://github.com/user-attachments/assets/a36ede48-f357-4b67-a948-b7cfbf4467f9)
* Now review and create the user.
* Now go inside the user for creating aws key and aws secret for connecting them.
* Go inside the security credentials tab and click on create access key.
![image](https://github.com/user-attachments/assets/d0112d9b-deb8-4c0d-9a13-b22a3b3649fd)
* Select third party services as forge is a third party service.
 ![image](https://github.com/user-attachments/assets/f963fe16-b0f2-4afc-9342-cd6d9c632efe)
* After clicking on create access key you will be prompted access key and access secret store it and also download its .csv file.
* Now Paste your access key and secret key on forge.
 ![image](https://github.com/user-attachments/assets/f4dd3945-c27a-4310-bdcb-aa61b19c0254)
* You can start a free trial or you could subscribe for monthly and yearly package.
* After filling billing details you will have option of create a new server.
 ![image](https://github.com/user-attachments/assets/9bdbf661-230f-4dc1-91a3-449cce264793)
* Now click on create server and select Aws.
* After that fill details like CPU, RAM, Region, PHP version, MySql Version, Server OS, Database Name, etc.
* You will get a popup which contains the server credentials Sudo password and Database Password for usage.
* Now if you go and check Ec2 instances it will contain a instance with the server name that you just submitted.
* Wait for status check to go green.(Normally there are 2 status checks.)
* Now for further installation to proceed (PHP, Ngix, SQL) we need to add security group to our instance.
* Create a security group
 ![image](https://github.com/user-attachments/assets/e0077e19-e8a4-459d-9638-f2dd44401416)
 ![image](https://github.com/user-attachments/assets/b03cd348-0425-4d00-abcb-9729f5d507ce)
* Now add the inbound rules as shown in [documentation](https://forge.laravel.com/docs/servers/providers.html)
  ![image](https://github.com/user-attachments/assets/6c05d098-a2da-4ea3-94d6-4343fe2ea78f)
* Now for getting your systems ip address you can use following commands and add it in rules.
  For windows
  ```bash
  nslookup -type=TXT o-o.myaddr.l.google.com ns1.google.com
  ```
  For Mac
  ```bash
  dig -4 TXT +short o-o.myaddr.l.google.com @nsl.google.com
  ```
* Go inside instances and change the default security group that you created with new security group.
* After updating security group forge will start installing dependencies required to run the laravel project.
  
  



  


5.Connect your aws account with forge for deployment.
## Configurations of 


