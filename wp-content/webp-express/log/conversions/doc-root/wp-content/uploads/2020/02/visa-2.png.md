WebP Express 0.17.3. Conversion triggered with the conversion script (wod/webp-on-demand.php), 2020-02-27 14:16:24

*WebP Convert 2.3.0*  ignited.
- PHP version: 7.2.24-0ubuntu0.18.04.3
- Server software: Apache/2.4.29 (Ubuntu)

Stack converter ignited

Options:
------------
The following options have been set explicitly. Note: it is the resulting options after merging down the "jpeg" and "png" options and any converter-prefixed options.
- source: [doc-root]/wp-content/uploads/2020/02/visa-2.png
- destination: [doc-root]/wp-content/webp-express/webp-images/doc-root/wp-content/uploads/2020/02/visa-2.png.webp
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
- source: [doc-root]/wp-content/uploads/2020/02/visa-2.png
- destination: [doc-root]/wp-content/webp-express/webp-images/doc-root/wp-content/uploads/2020/02/visa-2.png.webp
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
- [doc-root]/wp-content/plugins/webp-express/vendor/rosell-dk/webp-convert/src/Convert/Converters/Binaries/cwebp-103-linux-x86-64
- [doc-root]/wp-content/plugins/webp-express/vendor/rosell-dk/webp-convert/src/Convert/Converters/Binaries/cwebp-103-linux-x86-64-static
- [doc-root]/wp-content/plugins/webp-express/vendor/rosell-dk/webp-convert/src/Convert/Converters/Binaries/cwebp-061-linux-x86-64
Detecting versions of the cwebp binaries found
- Executing: [doc-root]/wp-content/plugins/webp-express/vendor/rosell-dk/webp-convert/src/Convert/Converters/Binaries/cwebp-103-linux-x86-64 -version. Result: version: *1.0.3*
- Executing: [doc-root]/wp-content/plugins/webp-express/vendor/rosell-dk/webp-convert/src/Convert/Converters/Binaries/cwebp-103-linux-x86-64-static -version. Result: *Exec failed* (the cwebp binary was not found at path: [doc-root]/wp-content/plugins/webp-express/vendor/rosell-dk/webp-convert/src/Convert/Converters/Binaries/cwebp-103-linux-x86-64-static)
- Executing: [doc-root]/wp-content/plugins/webp-express/vendor/rosell-dk/webp-convert/src/Convert/Converters/Binaries/cwebp-061-linux-x86-64 -version. Result: version: *0.6.1*
Binaries ordered by version number.
- [doc-root]/wp-content/plugins/webp-express/vendor/rosell-dk/webp-convert/src/Convert/Converters/Binaries/cwebp-103-linux-x86-64: (version: 1.0.3)
- [doc-root]/wp-content/plugins/webp-express/vendor/rosell-dk/webp-convert/src/Convert/Converters/Binaries/cwebp-061-linux-x86-64: (version: 0.6.1)
Trying the first of these. If that should fail (it should not), the next will be tried and so on.
Creating command line options for version: 1.0.3
Quality: 85. 
The near-lossless option ignored for lossy
Trying to convert by executing the following command:
nice [doc-root]/wp-content/plugins/webp-express/vendor/rosell-dk/webp-convert/src/Convert/Converters/Binaries/cwebp-103-linux-x86-64 -metadata none -q 85 -alpha_q '85' -m 6 -low_memory '[doc-root]/wp-content/uploads/2020/02/visa-2.png' -o '[doc-root]/wp-content/webp-express/webp-images/doc-root/wp-content/uploads/2020/02/visa-2.png.webp.lossy.webp' 2>&1

*Output:* 
Saving file '[doc-root]/wp-content/webp-express/webp-images/doc-root/wp-content/uploads/2020/02/visa-2.png.webp.lossy.webp'
File:      [doc-root]/wp-content/uploads/2020/02/visa-2.png
Dimension: 22 x 15 (with alpha)
Output:    368 bytes Y-U-V-All-PSNR 41.02 38.30 38.18   39.88 dB
           (8.92 bpp)
block count:  intra4:          2  (100.00%)
              intra16:         0  (0.00%)
              skipped:         0  (0.00%)
bytes used:  header:             29  (7.9%)
             mode-partition:     13  (3.5%)
             transparency:       52 (99.0 dB)
 Residuals bytes  |segment 1|segment 2|segment 3|segment 4|  total
  intra4-coeffs:  |     142 |       0 |       0 |       0 |     142  (38.6%)
 intra16-coeffs:  |       0 |       0 |       0 |       0 |       0  (0.0%)
  chroma coeffs:  |      75 |       0 |       0 |       0 |      75  (20.4%)
    macroblocks:  |      100%|       0%|       0%|       0%|       2
      quantizer:  |      14 |      14 |      14 |      14 |
   filter level:  |       4 |       4 |       4 |       4 |
------------------+---------+---------+---------+---------+-----------------
 segments total:  |     217 |       0 |       0 |       0 |     217  (59.0%)
Lossless-alpha compressed size: 51 bytes
  * Header size: 40 bytes, image data size: 11
  * Lossless features used: PALETTE
  * Precision Bits: histogram=3 transform=3 cache=0
  * Palette size:   9

Success
Reduction: 78% (went from 1640 bytes to 368 bytes)

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
- [doc-root]/wp-content/plugins/webp-express/vendor/rosell-dk/webp-convert/src/Convert/Converters/Binaries/cwebp-103-linux-x86-64
- [doc-root]/wp-content/plugins/webp-express/vendor/rosell-dk/webp-convert/src/Convert/Converters/Binaries/cwebp-103-linux-x86-64-static
- [doc-root]/wp-content/plugins/webp-express/vendor/rosell-dk/webp-convert/src/Convert/Converters/Binaries/cwebp-061-linux-x86-64
Detecting versions of the cwebp binaries found
- Executing: [doc-root]/wp-content/plugins/webp-express/vendor/rosell-dk/webp-convert/src/Convert/Converters/Binaries/cwebp-103-linux-x86-64 -version. Result: version: *1.0.3*
- Executing: [doc-root]/wp-content/plugins/webp-express/vendor/rosell-dk/webp-convert/src/Convert/Converters/Binaries/cwebp-103-linux-x86-64-static -version. Result: *Exec failed* (the cwebp binary was not found at path: [doc-root]/wp-content/plugins/webp-express/vendor/rosell-dk/webp-convert/src/Convert/Converters/Binaries/cwebp-103-linux-x86-64-static)
- Executing: [doc-root]/wp-content/plugins/webp-express/vendor/rosell-dk/webp-convert/src/Convert/Converters/Binaries/cwebp-061-linux-x86-64 -version. Result: version: *0.6.1*
Binaries ordered by version number.
- [doc-root]/wp-content/plugins/webp-express/vendor/rosell-dk/webp-convert/src/Convert/Converters/Binaries/cwebp-103-linux-x86-64: (version: 1.0.3)
- [doc-root]/wp-content/plugins/webp-express/vendor/rosell-dk/webp-convert/src/Convert/Converters/Binaries/cwebp-061-linux-x86-64: (version: 0.6.1)
Trying the first of these. If that should fail (it should not), the next will be tried and so on.
Creating command line options for version: 1.0.3
Trying to convert by executing the following command:
nice [doc-root]/wp-content/plugins/webp-express/vendor/rosell-dk/webp-convert/src/Convert/Converters/Binaries/cwebp-103-linux-x86-64 -metadata none -q 85 -alpha_q '85' -near_lossless 60 -m 6 -low_memory '[doc-root]/wp-content/uploads/2020/02/visa-2.png' -o '[doc-root]/wp-content/webp-express/webp-images/doc-root/wp-content/uploads/2020/02/visa-2.png.webp.lossless.webp' 2>&1

*Output:* 
Saving file '[doc-root]/wp-content/webp-express/webp-images/doc-root/wp-content/uploads/2020/02/visa-2.png.webp.lossless.webp'
File:      [doc-root]/wp-content/uploads/2020/02/visa-2.png
Dimension: 22 x 15
Output:    698 bytes (16.92 bpp)
Lossless-ARGB compressed size: 698 bytes
  * Header size: 422 bytes, image data size: 250
  * Lossless features used: PALETTE
  * Precision Bits: histogram=3 transform=3 cache=2
  * Palette size:   187

Success
Reduction: 57% (went from 1640 bytes to 698 bytes)


*Warning: filesize(): stat failed for [doc-root]/wp-content/webp-express/webp-images/doc-root/wp-content/uploads/2020/02/visa-2.png.webp.lossy.webp in [doc-root]/wp-content/plugins/webp-express/vendor/rosell-dk/webp-convert/src/Convert/Converters/ConverterTraits/EncodingAutoTrait.php, line 70, PHP 7.2.24-0ubuntu0.18.04.3 (Linux)* 


*Warning: filesize(): stat failed for [doc-root]/wp-content/webp-express/webp-images/doc-root/wp-content/uploads/2020/02/visa-2.png.webp.lossy.webp in [doc-root]/wp-content/plugins/webp-express/vendor/rosell-dk/webp-convert/src/Convert/Converters/ConverterTraits/EncodingAutoTrait.php, line 70, PHP 7.2.24-0ubuntu0.18.04.3 (Linux)* 

Picking lossy

*Warning: rename([doc-root]/wp-content/webp-express/webp-images/doc-root/wp-content/uploads/2020/02/visa-2.png.webp.lossy.webp,[doc-root]/wp-content/webp-express/webp-images/doc-root/wp-content/uploads/2020/02/visa-2.png.webp): No such file or directory in [doc-root]/wp-content/plugins/webp-express/vendor/rosell-dk/webp-convert/src/Convert/Converters/ConverterTraits/EncodingAutoTrait.php, line 73, PHP 7.2.24-0ubuntu0.18.04.3 (Linux)* 


*Warning: rename([doc-root]/wp-content/webp-express/webp-images/doc-root/wp-content/uploads/2020/02/visa-2.png.webp.lossy.webp,[doc-root]/wp-content/webp-express/webp-images/doc-root/wp-content/uploads/2020/02/visa-2.png.webp): No such file or directory in [doc-root]/wp-content/plugins/webp-express/vendor/rosell-dk/webp-convert/src/Convert/Converters/ConverterTraits/EncodingAutoTrait.php, line 73, PHP 7.2.24-0ubuntu0.18.04.3 (Linux)* 

cwebp succeeded :)

Converted image in 18479 ms, reducing file size with 78% (went from 1640 bytes to 368 bytes)
