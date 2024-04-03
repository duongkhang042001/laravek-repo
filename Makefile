ROOT_DIR:=$(shell dirname $(realpath $(firstword $(MAKEFILE_LIST))))

.PHONY: dev
dev: 
	cp .env.dev .env
	docker run --rm -d -p 8088:80 --env WEB_DOCUMENT_ROOT=/app/public --name sms-api-private -v $(ROOT_DIR):/app webdevops/php-nginx:8.1-alpine
