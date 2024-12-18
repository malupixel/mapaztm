FROM alpine:3.11

RUN apk add --update nginx
RUN apk add --update bash
RUN apk add --update nano
RUN rm -rf /var/cache/apk/* && rm -rf /tmp/*

ADD nginx.conf /etc/nginx/
ADD automapa.conf /etc/nginx/conf.d/

RUN echo "upstream php-upstream { server automapa_php:9004; }" > /etc/nginx/conf.d/upstream.conf

RUN adduser -D -g '' -G www-data www-data

CMD ["nginx"]

EXPOSE 8089
EXPOSE 9099
