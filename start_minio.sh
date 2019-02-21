#!/usr/bin/env bash

mkdir -p minio/{data,config}



docker run --rm -p 8080:9000 --name minio1 \
  -e "MINIO_ACCESS_KEY=AKIAIOSFODNN7EXAMPLE" \
  -e "MINIO_SECRET_KEY=wJalrXUtnFEMI/K7MDENG/bPxRfiCYEXAMPLEKEY" \
  -v $PWD/minio/data:/data \
  -v $PWD/minio/config:/root/.minio \
  minio/minio server /data
