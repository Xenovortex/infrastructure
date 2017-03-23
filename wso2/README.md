# Installation and Configs of WSO2

## Prerequisities

Reference [page](https://docs.wso2.com/display/AM210/Installation+Prerequisites)

1. Oracle JDK (1.7 or 1.8), then config `JAVA_HOME`
2. Apache ActiveMQ JMS Provider, but DON'T start it

## Install from binary

Reference [page](https://docs.wso2.com/display/AM210/Installing+the+Product)

1. Download the WSO2 API Manger package
2. Unzip it to `<PRODUCT_HOME>`
3. Copy the `activemq-all-x.x.x.jar` to `<PRODUCT_HOME>/repository/lib/`
4. Run `<PRODUCT_HOME>/bin/wso2server.sh`
5. Go get a coffee
