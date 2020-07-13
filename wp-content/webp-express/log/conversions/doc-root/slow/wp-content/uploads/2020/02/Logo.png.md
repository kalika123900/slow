WebP Express 0.17.3. Conversion triggered with the conversion script (wod/webp-on-demand.php), 2020-03-16 14:51:19

*WebP Convert 2.3.0*  ignited.
- PHP version: 7.2.26
- Server software: Apache/2.4.41 (Unix) OpenSSL/1.1.1d PHP/7.2.26 mod_perl/2.0.8-dev Perl/v5.16.3

Stack converter ignited
Destination folder does not exist. Creating folder: [doc-root]/slow/wp-content/webp-express/webp-images/doc-root/slow/wp-content/uploads/2020/02

Options:
------------
The following options have been set explicitly. Note: it is the resulting options after merging down the "jpeg" and "png" options and any converter-prefixed options.
- source: [doc-root]/slow/wp-content/uploads/2020/02/Logo.png
- destination: [doc-root]/slow/wp-content/webp-express/webp-images/doc-root/slow/wp-content/uploads/2020/02/Logo.png.webp
- log-call-arguments: true
- converters: (array of 9 items)

The following options have not been explicitly set, so using the following defaults:
- converter-options: (empty array)
- shuffle: false
- preferred-converters: (empty array)
- extra-converters: (empty array)

The following options were supplied and are passed on to the converters in the stack:
- alpha-quality: 85
- encoding: "auto"
- metadata: "none"
- near-lossless: 60
- quality: 85
------------


*Trying: cwebp* 

Options:
------------
The following options have been set explicitly. Note: it is the resulting options after merging down the "jpeg" and "png" options and any converter-prefixed options.
- source: [doc-root]/slow/wp-content/uploads/2020/02/Logo.png
- destination: [doc-root]/slow/wp-content/webp-express/webp-images/doc-root/slow/wp-content/uploads/2020/02/Logo.png.webp
- alpha-quality: 85
- encoding: "auto"
- low-memory: true
- log-call-arguments: true
- metadata: "none"
- method: 6
- near-lossless: 60
- quality: 85
- use-nice: true
- command-line-options: ""
- try-common-system-paths: true
- try-supplied-binary-for-os: true

The following options have not been explicitly set, so using the following defaults:
- auto-filter: false
- default-quality: 85
- max-quality: 85
- preset: "none"
- size-in-percentage: null (not set)
- skip: false
- rel-path-to-precompiled-binaries: *****
- try-cwebp: true
- try-discovering-cwebp: true
------------

Encoding is set to auto - converting to both lossless and lossy and selecting the smallest file

Converting to lossy
Looking for cwebp binaries.
Discovering if a plain cwebp call works (to skip this step, disable the "try-cwebp" option)
- Executing: cwebp -version. Result: *Exec failed* (the cwebp binary was not found at path: cwebp)
Nope a plain cwebp call does not work
Discovering binaries using "which -a cwebp" command. (to skip this step, disable the "try-discovering-cwebp" option)
Found 0 binaries
Discovering binaries by peeking in common system paths (to skip this step, disable the "try-common-system-paths" option)
Found 0 binaries
Discovering binaries which are distributed with the webp-convert library (to skip this step, disable the "try-supplied-binary-for-os" option)
Checking if we have a supplied precompiled binary for your OS (Linux)... We do. We in fact have 3
Found 3 binaries: 
- [doc-root]/slow/wp-content/plugins/webp-express/vendor/rosell-dk/webp-convert/src/Convert/Converters/Binaries/cwebp-103-linux-x86-64
- [doc-root]/slow/wp-content/plugins/webp-express/vendor/rosell-dk/webp-convert/src/Convert/Converters/Binaries/cwebp-103-linux-x86-64-static
- [doc-root]/slow/wp-content/plugins/webp-express/vendor/rosell-dk/webp-convert/src/Convert/Converters/Binaries/cwebp-061-linux-x86-64
Detecting versions of the cwebp binaries found
- Executing: [doc-root]/slow/wp-content/plugins/webp-express/vendor/rosell-dk/webp-convert/src/Convert/Converters/Binaries/cwebp-103-linux-x86-64 -version. Result: version: *1.0.3*
- Executing: [doc-root]/slow/wp-content/plugins/webp-express/vendor/rosell-dk/webp-convert/src/Convert/Converters/Binaries/cwebp-103-linux-x86-64-static -version. Result: *Exec failed* (the cwebp binary was not found at path: [doc-root]/slow/wp-content/plugins/webp-express/vendor/rosell-dk/webp-convert/src/Convert/Converters/Binaries/cwebp-103-linux-x86-64-static)
- Executing: [doc-root]/slow/wp-content/plugins/webp-express/vendor/rosell-dk/webp-convert/src/Convert/Converters/Binaries/cwebp-061-linux-x86-64 -version. Result: version: *0.6.1*
Binaries ordered by version number.
- [doc-root]/slow/wp-content/plugins/webp-express/vendor/rosell-dk/webp-convert/src/Convert/Converters/Binaries/cwebp-103-linux-x86-64: (version: 1.0.3)
- [doc-root]/slow/wp-content/plugins/webp-express/vendor/rosell-dk/webp-convert/src/Convert/Converters/Binaries/cwebp-061-linux-x86-64: (version: 0.6.1)
Trying the first of these. If that should fail (it should not), the next will be tried and so on.
Creating command line options for version: 1.0.3
Quality: 85. 
The near-lossless option ignored for lossy
Trying to convert by executing the following command:
nice [doc-root]/slow/wp-content/plugins/webp-express/vendor/rosell-dk/webp-convert/src/Convert/Converters/Binaries/cwebp-103-linux-x86-64 -metadata none -q 85 -alpha_q '85' -m 6 -low_memory '[doc-root]/slow/wp-content/uploads/2020/02/Logo.png' -o '[doc-root]/slow/wp-content/webp-express/webp-images/doc-root/slow/wp-content/uploads/2020/02/Logo.png.webp.lossy.webp' 2>&1

*Output:* 
libpng warning: iCCP: known incorrect sRGB profile
libpng warning: iCCP: cHRM chunk does not match sRGB
Saving file '[doc-root]/slow/wp-content/webp-express/webp-images/doc-root/slow/wp-content/uploads/2020/02/Logo.png.webp.lossy.webp'
File:      [doc-root]/slow/wp-content/uploads/2020/02/Logo.png
Dimension: 2019 x 1088 (with alpha)
Output:    47808 bytes Y-U-V-All-PSNR 71.51 99.00 99.00   73.28 dB
           (0.17 bpp)
block count:  intra4:        272  (3.15%)
              intra16:      8364  (96.85%)
              skipped:      8161  (94.50%)
bytes used:  header:            116  (0.2%)
             mode-partition:   5571  (11.7%)
             transparency:    40500 (74.3 dB)
 Residuals bytes  |segment 1|segment 2|segment 3|segment 4|  total
  intra4-coeffs:  |     106 |       0 |       0 |       0 |     106  (0.2%)
 intra16-coeffs:  |    1451 |       0 |       0 |       0 |    1451  (3.0%)
  chroma coeffs:  |       6 |       0 |       0 |       0 |       6  (0.0%)
    macroblocks:  |      20%|       0%|       0%|      80%|    8636
      quantizer:  |      20 |      19 |      16 |      11 |
   filter level:  |       7 |       4 |       3 |       0 |
------------------+---------+---------+---------+---------+-----------------
 segments total:  |    1563 |       0 |       0 |       0 |    1563  (3.3%)
Lossless-alpha compressed size: 40499 bytes
  * Header size: 274 bytes, image data size: 40225
  * Lossless features used: PALETTE
  * Precision Bits: histogram=5 transform=4 cache=0
  * Palette size:   136

Success
Reduction: 57% (went from 110 kb to 47 kb)

Converting to lossless
Looking for cwebp binaries.
Discovering if a plain cwebp call works (to skip this step, disable the "try-cwebp" option)
- Executing: cwebp -version. Result: *Exec failed* (the cwebp binary was not found at path: cwebp)
Nope a plain cwebp call does not work
Discovering binaries using "which -a cwebp" command. (to skip this step, disable the "try-discovering-cwebp" option)
Found 0 binaries
Discovering binaries by peeking in common system paths (to skip this step, disable the "try-common-system-paths" option)
Found 0 binaries
Discovering binaries which are distributed with the webp-convert library (to skip this step, disable the "try-supplied-binary-for-os" option)
Checking if we have a supplied precompiled binary for your OS (Linux)... We do. We in fact have 3
Found 3 binaries: 
- [doc-root]/slow/wp-content/plugins/webp-express/vendor/rosell-dk/webp-convert/src/Convert/Converters/Binaries/cwebp-103-linux-x86-64
- [doc-root]/slow/wp-content/plugins/webp-express/vendor/rosell-dk/webp-convert/src/Convert/Converters/Binaries/cwebp-103-linux-x86-64-static
- [doc-root]/slow/wp-content/plugins/webp-express/vendor/rosell-dk/webp-convert/src/Convert/Converters/Binaries/cwebp-061-linux-x86-64
Detecting versions of the cwebp binaries found
- Executing: [doc-root]/slow/wp-content/plugins/webp-express/vendor/rosell-dk/webp-convert/src/Convert/Converters/Binaries/cwebp-103-linux-x86-64 -version. Result: version: *1.0.3*
- Executing: [doc-root]/slow/wp-content/plugins/webp-express/vendor/rosell-dk/webp-convert/src/Convert/Converters/Binaries/cwebp-103-linux-x86-64-static -version. Result: *Exec failed* (the cwebp binary was not found at path: [doc-root]/slow/wp-content/plugins/webp-express/vendor/rosell-dk/webp-convert/src/Convert/Converters/Binaries/cwebp-103-linux-x86-64-static)
- Executing: [doc-root]/slow/wp-content/plugins/webp-express/vendor/rosell-dk/webp-convert/src/Convert/Converters/Binaries/cwebp-061-linux-x86-64 -version. Result: version: *0.6.1*
Binaries ordered by version number.
- [doc-root]/slow/wp-content/plugins/webp-express/vendor/rosell-dk/webp-convert/src/Convert/Converters/Binaries/cwebp-103-linux-x86-64: (version: 1.0.3)
- [doc-root]/slow/wp-content/plugins/webp-express/vendor/rosell-dk/webp-convert/src/Convert/Converters/Binaries/cwebp-061-linux-x86-64: (version: 0.6.1)
Trying the first of these. If that should fail (it should not), the next will be tried and so on.
Creating command line options for version: 1.0.3
Trying to convert by executing the following command:
nice [doc-root]/slow/wp-content/plugins/webp-express/vendor/rosell-dk/webp-convert/src/Convert/Converters/Binaries/cwebp-103-linux-x86-64 -metadata none -q 85 -alpha_q '85' -near_lossless 60 -m 6 -low_memory '[doc-root]/slow/wp-content/uploads/2020/02/Logo.png' -o '[doc-root]/slow/wp-content/webp-express/webp-images/doc-root/slow/wp-content/uploads/2020/02/Logo.png.webp.lossless.webp' 2>&1

*Output:* 
libpng warning: iCCP: known incorrect sRGB profile
libpng warning: iCCP: cHRM chunk does not match sRGB
Saving file '[doc-root]/slow/wp-content/webp-express/webp-images/doc-root/slow/wp-content/uploads/2020/02/Logo.png.webp.lossless.webp'
File:      [doc-root]/slow/wp-content/uploads/2020/02/Logo.png
Dimension: 2019 x 1088
Output:    43780 bytes (0.16 bpp)
Lossless-ARGB compressed size: 43780 bytes
  * Header size: 86 bytes, image data size: 43669
  * Lossless features used: PALETTE
  * Precision Bits: histogram=5 transform=4 cache=0
  * Palette size:   256

Success
Reduction: 61% (went from 110 kb to 43 kb)

Picking lossless
cwebp succeeded :)

Converted image in 950 ms, reducing file size with 61% (went from 110 kb to 43 kb)
