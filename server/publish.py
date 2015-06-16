# publish.py - automation script
#
# Copyright 2010 Dario Malfatti <info@asktomyself.com>
#
# Script to automatically:
#	- compile a js script
# 	- upload it to the website
#

import os
import sys
import shutil
import getpass
import smtplib
import subprocess

from ftplib import FTP
from email.mime.text import MIMEText
from shutil import copy

def compile_java(dirPath, fileName):
        sys.stdout.write('compiling ' + os.path.join(dirPath, fileName))
        args = [r'java',
                r'-jar',
                r'compiler.jar',
                r'--js=' + os.path.join(dirPath, fileName),
                r'--js_output_file=' + os.path.join(os.path.join(dirPath, 'out'), fileName)]
        ret = subprocess.call(args)
        if ret:
                sys.stderr.write('error while compiling the script, exit code %d\n' % ret)
                return False
        else:
                sys.stdout.write('...ok\n')
                return True

def send_dir_to_ftp(ftp, directory_local, directory_ftp, ext):

        sys.stdout.write('ftp go to dir: ' + directory_ftp + '\n')
        ftp.cwd('/domains/asktomyself.com/public_html/' + directory_ftp)
    
        l = os.listdir(os.path.abspath(directory_local))
        
        for f in l:
                
                if f.endswith(ext):
                        
                        sys.stdout.write('sending file: ' + f)
                        the_file = open(os.path.join(directory_local, f), 'rb')
                        ftp.storbinary('STOR ' + f, the_file)
                        the_file.close()
                        sys.stdout.write('...ok\n')
                        
	# delete test file
	if directory_local == 'service':
		
		sys.stdout.write('delete test file')
		ftp.delete('test.php')
		sys.stdout.write('...ok\n')
			

if __name__ == '__main__':

        sys.stdout.write('compiling javascript\n')

        # compile js scripts
        
        script_folder = 'script'
        
        l = os.listdir(script_folder)
        
        for f in l:
                if f.endswith('.js'):
                        if f != 'jquery.js' and f != 'jquery.json.js' and f != 'jquery-ui-1.8.4.custom.min.js':
                                ret = compile_java(script_folder, f)
                                if not ret:
                                        sys.stderr.write('operation aborted\n')
                                        sys.exit(1)
                        else:
                                copy(os.path.join(script_folder, f), 
                                    os.path.join(os.path.join(script_folder, 'out'), f))
                        
        # open the ftp connection
        sys.stdout.write('open ftp connection\n')
        ftp = FTP('asktomyself.com', 'w74408', 'arftZ0RrMN')
        
        # send js files compiled to ftp
        send_dir_to_ftp(ftp, os.path.join(script_folder, 'out'), 'script', '.js')
        
        # send css files
        send_dir_to_ftp(ftp, 'css', 'css', '.css')
        
        # send images files
        send_dir_to_ftp(ftp, 'images', 'images', '.png')
        send_dir_to_ftp(ftp, 'images', 'images', '.gif')
        
        # send include files
        send_dir_to_ftp(ftp, 'include', 'include', '.php')
        
        # send modules files
        send_dir_to_ftp(ftp, 'modules', 'modules', '.php')
        
        # send service files
        send_dir_to_ftp(ftp, 'service', 'service', '.php')
        
        # send login files
        send_dir_to_ftp(ftp, 'login', 'login', '.php')
        
        # send generic pages
        send_dir_to_ftp(ftp, 'pages', 'pages', '.html')
        
        # send css files
        send_dir_to_ftp(ftp, 'css', 'css', '.css')
        
        # send css files
        send_dir_to_ftp(ftp, os.path.join('templates','email'), 'templates/email', '.html')
        send_dir_to_ftp(ftp, os.path.join('templates','email'), 'templates/email', '.txt')
        
        # send the index
        send_dir_to_ftp(ftp, './', '', '.php')
        
        # close the ftp connection
        sys.stdout.write('close ftp connection\n')
        ftp.quit()
        
        sys.stdout.write('publish complete!\n')
