<p align="center"><a href="https://laravel.com" target="_blank"><img src="https://raw.githubusercontent.com/laravel/art/master/logo-lockup/5%20SVG/2%20CMYK/1%20Full%20Color/laravel-logolockup-cmyk-red.svg" width="400" alt="Laravel Logo"></a></p>

<p align="center">
<a href="https://github.com/laravel/framework/actions"><img src="https://github.com/laravel/framework/workflows/tests/badge.svg" alt="Build Status"></a>
<a href="https://packagist.org/packages/laravel/framework"><img src="https://img.shields.io/packagist/dt/laravel/framework" alt="Total Downloads"></a>
<a href="https://packagist.org/packages/laravel/framework"><img src="https://img.shields.io/packagist/v/laravel/framework" alt="Latest Stable Version"></a>
<a href="https://packagist.org/packages/laravel/framework"><img src="https://img.shields.io/packagist/l/laravel/framework" alt="License"></a>
</p>

## About Laravel

Laravel is a web application framework with expressive, elegant syntax. We believe development must be an enjoyable and creative experience to be truly fulfilling. Laravel takes the pain out of development by easing common tasks used in many web projects, such as:

## Deployment On Forge with AWS EC2

### Step 1: Sign Up and Connect to GitHub

1. **Sign up for an account on Forge.**
2. **Connect your Forge account with GitHub.** Authorize GitHub to connect with your repository.
   ![Connect with GitHub](https://github.com/user-attachments/assets/11e406f5-b7b2-47d2-b231-3503272f7f1b)

### Step 2: Select Service Provider

1. **Select your service provider** (e.g., AWS).
   ![image](https://github.com/user-attachments/assets/edf4f84b-85c2-48f0-acb9-f0e6cc45bed6)
2. **Follow the instructions** for AWS EC2 settings. For other providers, refer to the [documentation](https://forge.laravel.com/docs/servers/providers.html).

### Step 3: Set Up AWS IAM User

1. **Go to the IAM dashboard** of AWS.
   ![image](https://github.com/user-attachments/assets/887604ab-8fb8-4392-bdd3-24a8c179366e)
2. **Create a new user** for this project.
   ![image](https://github.com/user-attachments/assets/8c576821-0993-444e-b98e-78f963dbede1)
3. **Assign necessary policies**: AmazonEC2FullAccess and AmazonVPCFullAccess. Create a group with these policies or attach them directly to the user.
   ![image](https://github.com/user-attachments/assets/d0dcc512-fc5f-41d1-a805-02a6bdbd9027)
4. **Create access keys** for connecting to Forge.
   ![image](https://github.com/user-attachments/assets/d0112d9b-deb8-4c0d-9a13-b22a3b3649fd)
5. **Select third-party services** and store the access key and secret key.
   ![image](https://github.com/user-attachments/assets/f963fe16-b0f2-4afc-9342-cd6d9c632efe)
6. **Paste the keys** into Forge.
  ![image](https://github.com/user-attachments/assets/28bd2b27-c3d5-4c64-a404-58d12b8f2a77)
### Step 4: Create and Configure Server

1. **Start a free trial** or subscribe to a package.
2. **Create a new server** and select AWS.
   ![image](https://github.com/user-attachments/assets/9bdbf661-230f-4dc1-91a3-449cce264793)
3. **Fill in the details**: CPU, RAM, Region, PHP version, MySQL version, Server OS, Database Name, etc.
4. **Copy server credentials**: Sudo password and Database Password.
5. **Check the EC2 instance** for the new server.
6. **Wait for status checks** to turn green (usually two status checks).
7. **Add security group** to the instance.
   ![image](https://github.com/user-attachments/assets/e0077e19-e8a4-459d-9638-f2dd44401416)
8. **Add inbound rules** as shown in the [documentation](https://forge.laravel.com/docs/servers/providers.html).
   ![image](https://github.com/user-attachments/assets/6c05d098-a2da-4ea3-94d6-4343fe2ea78f)
9. **Get your system's IP address**:
   - For Windows:
     ```bash
     nslookup -type=TXT o-o.myaddr.l.google.com ns1.google.com
     ```
   - For Mac:
     ```bash
     dig -4 TXT +short o-o.myaddr.l.google.com @nsl.google.com
     ```
10. **Update the security group** with the new security group.
11. **Forge will install dependencies** required to run the Laravel project.

### Step 5: Deploy Your Application

1. **Access the server address** to see the Forge landing page.
   ![image](https://github.com/user-attachments/assets/b04dcd81-9b93-41a1-a38d-0a2e446851cd)
2. **Install the application**:
  ![image](https://github.com/user-attachments/assets/c4051bf3-5579-4770-bbf9-23bf882059e2)
3. **Connect to your Git repository**:
   - Paste the repository link.
   - Select the branch of the repository.
   - Enable "Install Composer dependencies."
   ![image](https://github.com/user-attachments/assets/330b277c-601f-4f62-b045-04b1c0f54cc6)
4. **Set up CI/CD pipeline**:
   - Enable quick deploy to deploy your application automatically on new commits.
   ![image](https://github.com/user-attachments/assets/d99840ff-1130-4b4f-a0b1-9f0dafe8990b)
5. **Access your application** through the server IP.
6. **Success!** Your Laravel application is now deployed.

## Setting enviorment on forge
You can add your enviorment inside enviorment tab of your server on forge but as most of the services like MySql, Redis comes with it you don't need to add remote redis or database but if your requirement says otherwise you can always go there and change it.
![image](https://github.com/user-attachments/assets/046ce6c4-3991-490e-85f8-079eb9575674)

## Checking logs of laravel on forge
 you can go into logs tab to check the logs and errors of the server.
 ![image](https://github.com/user-attachments/assets/0362bdd1-5f22-4f34-a88f-e84ddb30746b)


 

