#!/usr/bin/perl

### DIARIOSEC GROUP ###
## B3RG & IRONBITS ##
### www.Ironbits.me ###

use LWP::UserAgent;

$ua = LWP::UserAgent->new;


if ($#ARGV + 1 != 2){
	print "Usage: scylla_f1nd3r <url> <path>\n";
	exit;
}

if ($ARGV[0] =~ m/^http/) { $url = $ARGV[0]; } else { $url = "http://".$ARGV[0]; }

$file = $ARGV[1];

if (!open(FILE, $file)){
	print "Invalid file!\n";
	exit;
}

print "\n====== Requesting to $url ========\n";

while (<FILE>){
	if ($_ =~ m/^\//){
		$request = HTTP::Request->new(GET => "$url$_");
		$response = $ua->request($request);
		if ($response->is_success){
			print $response->status_line." : $_";
		}
	}
}

print "\n\n";
close(FILE);
exit;
