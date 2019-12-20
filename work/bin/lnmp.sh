#!/bin/sh

#ruby -e "$(curl -fsSL https://raw.githubusercontent.com/Homebrew/install/master/install)"

#brew tap homebrew/dupes
#brew tap homebrew/versions
#brew tap homebrew/php

brew install php56 \
--without-snmp \
--without-apache \
--with-debug \
--with-fpm \
--with-intl \
--with-homebrew-curl \
--with-homebrew-libxslt \
--with-homebrew-openssl \
--with-imap \
--with-mysqli \
--with-tidy
