######################################
# docker-openresearch-stack          #
######################################

ARG MEDIAWIKI_VERSION=1.39.13
ARG OPENRESEARCH_STACK_VERSION=1.39.13-001

FROM gesinn/mediawiki:${MEDIAWIKI_VERSION}

# start from scratch
#RUN rm -rf LocalSettings.php /var/www/data

# install required packages
RUN \
	### install required apt packages
	#
	# cron 6)
	# ghostscript 1)
	# gnupg 3)
	# imagemagick 1)
	# libpng-dev 4)
	# libzip-dev 5)
	# poppler-utils 1)
	# software-properties-common 3)
	# wget 3)
	# zip 5)
	# zlib1g-dev 4)
	# libldap2-dev 8)
	#
	# 1) PDFHandler
	# 3) External_Data PlantUML
	# 4) php-gd / QRLite (PNG)
	# 5) SemanticResultFormats (phpoffice/phpspreadsheet)
	# 6) running jobs
	# 7) caching
	# 8) LDAP
	apt-get update && \
	apt-get install -y cron ghostscript gnupg imagemagick libpng-dev libzip-dev poppler-utils software-properties-common wget zip zlib1g-dev libldap2-dev && \
	rm -rf /var/lib/apt/lists/* && \
	#
	#
	### install required php packages
	#
	# gd 1)
	# zip 2)
	#
	# 1) QRLite (PNG)
	# 2) SemanticResultFormats (phpoffice/phpspreadsheet)
	docker-php-ext-install gd zip && \
    #
	### Set permissions (set to 1777 by default at https://github.com/docker-library/php/commit/3dc959846f1d44d6c3200f657dee762885847a2c)
	# Required to support symlink the long path to short path "wiki-xxx -> ."
	chmod 755 /var/www/html && \
	#
	### Add build tools and patches folder
	curl -LJ https://github.com/gesinn-it-pub/docker-mediawiki-tools/archive/refs/tags/3.3.0.tar.gz | tar xzC / --strip-components 1

# override by custom tools
ADD tools /tools
ADD build-tools /build-tools
RUN chmod +x /build-tools/* /tools/*
ENV PATH="/tools:/build-tools:${PATH}"

### apply MediaWiki patches
ADD patches /patches

### add php-settings (production)
ADD php-settings /usr/local/etc/php/conf.d
RUN cp "$PHP_INI_DIR/php.ini-production" "$PHP_INI_DIR/conf.d/10-php.ini" && \
	chmod 644 /usr/local/etc/php/conf.d/*

### We need to change owner here to allow sync with work volume and vagrant user (being member of www-data group)
RUN chown -R www-data:www-data \
	/var/www/html/vendor \
	/var/www/html/composer.lock \
	/var/www/html/composer.local.json

######################################
# install Java                       #
#
# - External_Data PlantUML
######################################
RUN mkdir -p /etc/apt/keyrings && \
	wget -O - https://packages.adoptium.net/artifactory/api/gpg/key/public | tee /etc/apt/keyrings/adoptium.asc && \
	echo "deb [signed-by=/etc/apt/keyrings/adoptium.asc] https://packages.adoptium.net/artifactory/deb $(awk -F= '/^VERSION_CODENAME/{print$2}' /etc/os-release) main" | tee /etc/apt/sources.list.d/adoptium.list && \
	apt-get update && \
	apt-get install -y temurin-11-jre && \
	rm -rf /var/lib/apt/lists/*


######################################
# install PlantUML                   #
######################################
RUN wget http://netcologne.dl.sourceforge.net/project/plantuml/1.2022.2/plantuml-nodot.1.2022.2.jar -P /usr/share/java && \
    (cd /usr/share/java && ln -snf plantuml-nodot.1.2022.2.jar plantuml.jar)

USER www-data

RUN \
    ### Chameleon
    composer-require.sh mediawiki/chameleon-skin 4.3.0 && \
    #
    #
    ### AdminLinks
    get-github-extension.sh AdminLinks 0.6.3 && \
    #
    #
    ### ApprovedRevs
    get-github-extension.sh ApprovedRevs 2.0 && \
    #
    #
    ### Arrays (2024-04-28)
    get-github-extension.sh Arrays ad73997736fe27d31c7f531e494d827ab871d2ff && \
    #
    #
    ### AutoCreatePage
    get-github-extension.sh AutoCreatePage 1945b9dbcdb69d63a31df50467451e4b4d3a5290 gesinn-it-pub/AutoCreatePage && \
    #
    #
    ### Extension:CategoryTree (TODO: required?)
    #
    #
    ### Extension:WikiEditor
    ### Required by CodeEditor
    #
    #
    ### Extension:CodeEditor
    ### Requires WikiEditor
    #
    #
    ### CirrusSearch (dev-REL1_39)
    # other approaches to install from extension distributor or from source fails
    composer-require.sh mediawiki/cirrussearch dev-REL1_39 && \
    #
    #
    ### CookieWarning (2024-06-03)
    get-github-extension.sh CookieWarning 7326d988c373cd5f0fba9a0004cb9da4a8c2ba78 && \
    #
    #
    ### ConfirmAccount (REL1_39 2024-06-03)
    get-github-extension.sh ConfirmAccount 284b143df379afeb377d16e5b8ed6b5a3628439f && \
    #
    #
    ### ConfirmEdit (enabled as shipped with MediaWiki)
    #
    #
    ### CSS (2022-02-06)
    get-github-extension.sh CSS 91f9d53fc0c58e2772719cf5e9d0bfd3d12151d4 && \
    #
    #
    ### DateDiff (2024-05-18)
    get-github-extension.sh DateDiff 574a03ec520dc2f2efc15bb7135d3d94d86874f1 && \
    #
    #
    ### DisplayTitle (2025-01-31)
    # This is the last commit before MW 1.41 is required
    get-github-extension.sh DisplayTitle 7eee15151bffbc2c74bbf1c0154aeb888b0fcac0 wikimedia/mediawiki-extensions-DisplayTitle && \
    #
    #
    ### Echo (REL1_39 2024-05-13)
    get-github-extension.sh Echo 1ca913d35f0540813cb646b622c47fcaadff7af9 && \
    #
    #
    ### EditAccount (2025-02-20)
    get-github-extension.sh EditAccount 4bc14fa01ae997a492a7189a061218834188f231 gesinn-it-pub/EditAccount && \
    #
    #
    ### Elastica
    get-extension.sh Elastica https://github.com/gesinn-it/extdist.wmflabs.org/raw/main/dist/extensions/Elastica-REL1_39-426e234.tar.gz && \
    COMPOSER=composer.local.json composer config --json --merge extra.merge-plugin.include '["extensions/Elastica/composer.json"]' && \
    #
    #
    ### ExternalData
    get-github-extension.sh ExternalData 3.3 && \
    #
    #
    ### IDProvider
    get-github-extension.sh IDProvider 2.0.3 gesinn-it/IDProvider && \
    #
    #
    #### ImageMap (enabled as shipped with MediaWiki)
    #
    #
    ### JSBreadCrumbs
    get-github-extension.sh JSBreadCrumbs 1.1.1 && \
    #
    #
    ### LegalLogin (2024-05-18)
    get-github-extension.sh LegalLogin 88cbd83b53501a7f123e22cd81b6f1fd583a22ac && \
    #
    #
    ### Loops (REL1_39 2024-11-25)
    get-github-extension.sh Loops 83cd81d53ad49d1d46050203d74836f6d3534fea && \
    #
    #
    ### Maps
    composer-require.sh mediawiki/maps 10.2.0 && \
    #
    #
    ### Matomo
    get-github-extension.sh Matomo v5.0.0 DaSchTour/matomo-mediawiki-extension && \
    #
    #
    ### Mermaid
    composer-require.sh mediawiki/mermaid 3.1.0 && \
    #
    #
    ### Modern Timeline
    composer-require.sh professional-wiki/modern-timeline 1.2.2 && \
    #
    #
    ### MultimediaViewer (enabled as shipped with MediaWiki)
    #
    #
    ### NativeSvgHandler (2024-05-18)
    get-github-extension.sh NativeSvgHandler 34c8fef31ad4229dcb845502375af5f84093c73c && \
    #
    #
    ### NumberFormat (2024-05-18)
    get-github-extension.sh NumberFormat 77df860bf8157d468d080c09f06f62199986bbca && \
    #
    #
    ### OpenLayers (2024-05-18)
    get-github-extension.sh OpenLayers cc52c04c68a8e7ee80241edf4de4ec1413bf705e  && \
    #
    #
    ### ParserFunctions enabled as shipped with MediaWiki)
    #
    #
    ### PageForms
    get-github-extension.sh PageForms 5.3.4.8 gesinn-it-pub/mediawiki-extensions-PageForms && \
    #
    #
    ### TextExtracts (enabled as shipped with MediaWiki)
    #
    #
    ### PageImages (enabled as shipped with MediaWiki)
    #
    #
    ### Popups (2022-03-06)
    # TODO
    # RUN get-github-extension.sh Popups b6eb2627ff3f1fc93060f663efc2f8b302dbb376
    #
    #
    ### RegexFunctions (2024-05-19)
    get-github-extension.sh RegexFunctions d04157129d1c0bb85416d90eb16b0ffc5b448adf && \
    #
    #
    ### ReplaceText (enabled as shipped with MediaWiki)
    #
    #
    ### SemanticMediaWiki (2025-04-14)
    #composer-require.sh mediawiki/semantic-media-wiki 5.0.1 && \
    ## temp. use bccedaf220e81bdf0568423abea387948318d586 for https://github.com/SemanticMediaWiki/SemanticMediaWiki/commit/5941613b5ab0f09043fb0a150433d0784dcb2057
	get-github-extension.sh SemanticMediaWiki bccedaf220e81bdf0568423abea387948318d586 SemanticMediaWiki/SemanticMediaWiki && \
	COMPOSER=composer.local.json composer config --json --merge extra.merge-plugin.include '["extensions/SemanticMediaWiki/composer.json"]' && \
	#
    #
    ### SemanticCompoundQueries
    composer-require.sh mediawiki/semantic-compound-queries 3.0.0-beta && \
    #
    #
    ### SemanticDependencyUpdater
    get-github-extension.sh SemanticDependencyUpdater 4.0.0 gesinn-it/SemanticDependencyUpdater && \
    #
    #
    ### SemanticExtraSpecialProperties (2025-03-10)
    composer-require.sh mediawiki/semantic-extra-special-properties 4.0.0 && \
    #
    #
    ### SemanticResultFormats
    composer-require.sh phpoffice/phpspreadsheet 1.29.0 && \
    composer-require.sh mediawiki/semantic-result-formats 5.0.0 && \
    #
    #
    ### SimpleTooltip
    # TODO
    # RUN get-github-extension.sh SimpleTooltip 2476bff8f4555f86795c26ca5fdb7db99bfe58d1 Fannon/SimpleTooltip
    #
    #
    ### TitleIcon
    get-github-extension.sh TitleIcon 6.1 && \
    #
    #
    ### UrlGetParameters (2024-05-19)
    get-github-extension.sh UrlGetParameters cf2712be11210bdcc6c358ccd59935979e91b732 && \
    #
    #
    ### UserFunctions (2024-05-19)
    get-github-extension.sh UserFunctions 1f98fedf1509a8b497834aac9b5830afa2673a21 && \
    #
    #
    ### UserMerge (2024-03-26)
    # This is the last commit before MW 1.41 is required
    get-github-extension.sh UserMerge 2b76ea5165cec8c686c097799e1dc4f84c9aad71 && \
    #
    #
    ### Variables
    get-github-extension.sh Variables v2.5.3 && \
    #
    #
    ### VEForAll
    #get-github-extension.sh VEForAll 0.5.2 && \
    get-github-extension.sh VEForAll 3a71f9016a1a27cc53a69805ba84025f4574688e && \
    ### (Warning: patch applied to this extension, adding ext.visualEditor.mwgallery)
    patch.sh extensions/VEForAll/extension.json

######################################
# composer update                    #
######################################
RUN composer-update.sh

######################################
# patches                            #
######################################
# TODO
#RUN \
#    # Autocompletion in search field does not work
#    sed -i "s!ApiBase::LIMIT_SML1!100!g" \
#	    includes/api/Validator/ApiParamValidator.php

######################################
# add openresearch-stack settings    #
######################################
ADD --chown=www-data:www-data LocalSettings.Include.php /var/www/html/.
ADD --chown=www-data:www-data LocalSettings.OpenResearchStack /var/www/html/LocalSettings.OpenResearchStack

######################################
# set openresearch-stack version     #
######################################
RUN echo $OPENRESEARCH_STACK_VERSION > openresearch-stack-version.txt && \
    echo "\$wgOpenResearchStackVersion = '$OPENRESEARCH_STACK_VERSION';" >> LocalSettings.Include.php

######################################
# add php-settings                   #
######################################
# TODO: needs to be changed
#ADD php-settings /usr/local/etc/php/conf.d
#RUN chmod 644 /usr/local/etc/php/conf.d/*

# use as volume for persistent storage of data, e.g. the current LocalSettings.php
# TODO: do we need this?
# RUN mkdir /data

USER root
CMD [ "startup-container.sh" ]
