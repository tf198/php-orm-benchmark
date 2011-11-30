TARGETS = propel_14/vendor/propel propel_15/vendor/propel outlet_07/vendor/outlet

all: libs git_libs

libs: $(TARGETS)

git_libs: .git
	git submodule update --init

propel_14/vendor/propel: src/propel-1.4.2.tar.gz
	tar zxf $< -C propel_14/vendor
	sleep 1
	mv $@-1.4.2 $@

propel_15/vendor/propel: src/propel-1.5.6.tar.gz
	tar zxf $< -C propel_15/vendor
	sleep 1
	mv $@-1.5.6 $@
	
outlet_07/vendor/outlet: src/outlet-1.0RC1.tar.gz
	tar zxf $< -C outlet_07/vendor
	sleep 1
	mv $@-1.0RC1 $@
	
src/propel-%.tar.gz: 
	test -d src || mkdir src
	wget -O $@ http://files.propelorm.org/propel-$*.tar.gz
	
src/outlet-1.0RC1.tar.gz:
	test -d src || mkdir src
	wget -O $@ http://www.outlet-orm.org/downloads/outlet-1.0RC1.tar.gz
	
clean:
	rm -rf $(TARGETS)
	
.force: ;