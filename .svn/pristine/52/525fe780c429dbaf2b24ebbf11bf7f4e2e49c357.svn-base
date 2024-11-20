QT       +=  webkit svg network
SOURCES   =  webcapt.cpp filestore.cpp parameters.cpp main.cpp
HEADERS   =  webcapt.h filestore.h parameters.h main.h
CONFIG   +=  qt console
CONFIG   -= debug
LIBS     +=  -lfcgi -lssi -lcurl -lz

QMAKE_CXXFLAGS_RELEASE += -O3
QMAKE_CFLAGS_RELEASE += -O3
QMAKE_LFLAGS_RELEASE =

contains(CONFIG, static): {
  QTPLUGIN += qjpeg qgif qsvg qmng qico qtiff
  DEFINES  += STATIC_PLUGINS
}
