# JCampos FrontEnd + Ivois

Este servicio se ejecuta en PHP y se encarga de administrar la API de IVOIS para clientes, productos y documentos electronicos.

## Docker Container

### Build Docker

Mac OSX and Windows

```Shell
docker buildx build --platform linux/arm64 -t biller-frontend:latest .
```

### Run Docker

#### Mac OSX
```Shell
docker run -d -p 80:80 --env-file env --network dev.ivois.io -v ~/.aws:/root/.aws:ro --name biller-frontend biller-frontend:latest
```

#### Windows
```Shell
docker run -d -p 80:80 --env-file configurations.env --network dev.ivois.io -v %USERPROFILE%/.aws:/root/.aws:ro --name biller-frontend biller-frontend:latest
```


### AWS Login

```Shell
aws sso login --profile IVOIS-DEV
```

### Pull Docker to AWS Repository

#### 1. Create Repository
```Shell
--Create repository
aws ecr create-repository \
    --repository-name biller-frontend-ecr \
    --image-scanning-configuration scanOnPush=false \
    --region us-east-1 --profile IVOIS-DEV
```

-- Delete images
```Shell
aws ecr batch-delete-image \
    --repository-name biller-frontend-ecr \
    --image-ids imageTag=latest
```

-- Delete repository
```Shell
aws ecr delete-repository \
    --repository-name biller-frontend-ecr \
    --region us-east-1 --profile IVOIS-DEV
```

#### 2. Login AWS Account Elastic Container Repository

Mac OSX
```Shell
aws ecr get-login-password --region us-east-1 --profile IVOIS-DEV | docker login --username AWS --password-stdin 205784505678.dkr.ecr.us-east-1.amazonaws.com
```

Windows
```Shell
(Get-ECRLoginCommand).Password --profile IVOIS-DEV | docker login --username AWS --password-stdin  205784505678.dkr.ecr.us-east-1.amazonaws.com
```

#### 3. Tag Docker Image

```Shell
docker tag biller-frontend:latest 205784505678.dkr.ecr.us-east-1.amazonaws.com/biller-frontend-ecr:latest
```

#### 4. Push Docker Image

```Shell
docker push 205784505678.dkr.ecr.us-east-1.amazonaws.com/biller-frontend-ecr:latest
```

##  5. Update ECS Service

```Shell
aws ecs update-service --cluster IvoisDevCluster --service Ivois-FrontEnd-SVC --force-new-deployment --profile IVOIS-DEV
```

## CloudFormation Templates

AWS CloudFormation Templates for Document History Lambda Function

- AWS CloudFormation - AppConfig: this template allows to build the AppConfig of the project
- AWS CloudFormation - CodePipeline: this template allows to build the pipeline of the project
- AWS CloudFormation - CodePipeline Deploy: this template allows to build and deploy the resources

### AWS CloudFormation - AppConfig

The following template allows to build the AppConfig of the project for development and production.

To deploy:
```Shell
aws cloudformation deploy --stack-name ivois-dev-biller-frontend-appconfig --template-file ./cloudformation/appconfig.yml --profile IVOIS-DEV
```

To delete:
```Shell
aws cloudformation delete-stack --stack-name ivois-dev-biller-frontend-appconfig --profile IVOIS-DEV
```

### AWS CloudFormation - CodePipeline

The following template allows to build the pipeline of the project. It has the following stages:
- Source: GitHub Repository
- Build: CodeBuild
- Deploy:
  - App Config
  - Lambda

To deploy:
```Shell
aws cloudformation deploy --stack-name ivois-dev-biller-frontend-codepipeline --template-file ./cloudformation/codepipeline.yml --capabilities CAPABILITY_NAMED_IAM --profile IVOIS-DEV
```

To delete:
```Shell
aws cloudformation delete-stack --stack-name ivois-dev-biller-frontend-codepipeline --profile IVOIS-DEV
```

#### CodePipeline Parameters

- Development:

```json
{
  "ECRImageURIParam": "205784505678.dkr.ecr.us-east-1.amazonaws.com/biller-frontend:latest",
  "IvoisS3Param": "arn:aws:iam::205784505678:policy/IVOIS-DEV-S3",
  "ApiGatewayIDParam":"2jo37e2za4",
  "ApiGatewayResourceParentIDParam":"1clvuc",
  "StageParam":"DEV"
}
```

- Production:

```json
{
  "ECRImageURIParam": "205784505678.dkr.ecr.us-east-1.amazonaws.com/biller-frontend:latest",
  "IvoisS3Param": "arn:aws:iam::205784505678:policy/IVOIS-PROD-S3",
  "ApiGatewayIDParam":"2jo37e2za4",
  "ApiGatewayResourceParentIDParam":"1clvuc",
  "StageParam":"PROD"
}
```
#### Testing CodePipeline Deploy

```Shell
aws cloudformation deploy --stack-name ivois-dev-biller-frontend-cloudformation --template-file ./cloudformation.yml  --parameter-overrides ECRImageURIParam=205784505678.dkr.ecr.us-east-1.amazonaws.com/biller-frontend:latest  IvoisS3Param=arn:aws:iam::205784505678:policy/IVOIS-DEV-S3 ApiGatewayIDParam=2jo37e2za4 ApiGatewayResourceParentIDParam=1clvuc StageParam=DEV --capabilities CAPABILITY_NAMED_IAM --profile IVOIS-DEV
```


### Utils

### Lambda Layers : 
#### MySQL Connector for Python

##### Create Target Directory
```Shell
mkdir layer & cd layer
```

##### Install Python Module

#### Layer for ARM 3.8
```Shell
pip3 install --platform manylinux2014_aarch64 --target=./python/lib64/python3.8/site-packages --implementation cp --python 3.8 --only-binary=:all: --upgrade mysql-connector-python
```

#### Layer for ARM 3.9
```Shell
pip3 install --platform manylinux2014_aarch64 --target=./python/lib64/python3.9/site-packages --implementation cp --python 3.9 --only-binary=:all: --upgrade mysql-connector-python
```

#### Layer for x86_64 3.8
```Shell
pip3 install --platform manylinux2014_x86_64 --target=./python/lib/python3.8/site-packages --implementation cp --python 3.8 --only-binary=:all: --upgrade mysql-connector-python
```

#### Layer for x86_64 3.9
```Shell
pip3 install --platform manylinux2014_x86_64 --target=./python/lib/python3.9/site-packages --implementation cp --python 3.9 --only-binary=:all: --upgrade mysql-connector-python
```

##### Zip Layer and upload layer to AWS

```Shell
zip -r ../mysql_layer.zip .
```
