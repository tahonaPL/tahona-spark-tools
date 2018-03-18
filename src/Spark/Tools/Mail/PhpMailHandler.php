<?php


namespace Spark\Tools\Mail;


use Monolog\Logger;
use PHPMailer\PHPMailer\Exception;
use PHPMailer\PHPMailer\PHPMailer;
use Spark\Core\Annotation\Inject;
use Spark\Core\Annotation\PostConstruct;
use Spark\Utils\FilterUtils;
use Spark\Utils\Objects;
use Spark\Utils\StringUtils;
use tahona\core\logger\LoggerFactory;

class PhpMailHandler implements MailHandler {

    /**
     * @var Logger
     */
    private $logger;

    /**
     * @Inject()
     * @var LoggerFactory
     */
    private $loggerFactory;


    /**
     * @PostConstruct()
     */
    public function init() {
        $this->logger = $this->loggerFactory->getLogger(PhpMailHandler::class);
    }

    public function send(Mail $mailData, MailerConfig $config) {

        $mail = new PHPMailer(true);                              // Passing `true` enables exceptions
        $this->logger->info('Message sending');

        try {
            //Server settings
            $mail->SMTPDebug = 2; // Enable verbose debug output
            $mail->CharSet = "UTF-8";

            $mail->isSMTP();                                      // Set mailer to use SMTP
            $mail->Host = StringUtils::join(";", $config->getHosts());  // Specify main and backup SMTP servers
            $mail->SMTPAuth = true;                               // Enable SMTP authentication
            $mail->Username = $config->getUserName();                 // SMTP username
            $mail->Password = $config->getPassword();                           // SMTP password
            $mail->SMTPSecure = $config->getSecurityProtocol();                            // Enable TLS encryption, `ssl` also accepted
            $mail->Port = $config->getPort();                                    // TCP port to connect to

            //Recipients
            $mail->setFrom($mailData->getFrom(), $mailData->getFromName());
            $mail->addAddress($mailData->getTo(), $mailData->getToName());     // Add a recipient

            if (Objects::isNotNull($mailData->getCc())) {
                $mail->addCC($mailData->getCc());
            }
//            $mail->addBCC('bcc@example.com');

            //Attachments
//            $mail->addAttachment('/var/tmp/file.tar.gz');         // Add attachments
//            $mail->addAttachment('/tmp/image.jpg', 'new.jpg');    // Optional name

            //Content
            $mail->isHTML(true);
            $mail->Subject = $mailData->getTitle();
            $mail->Body = $mailData->getContent();
            $mail->AltBody = FilterUtils::stripTags($mailData->getContent());

            $mail->send();

            $this->logger->info('Message has been sent');

        } catch (Exception $e) {
            $this->logger->info($e->getMessage());
            $this->logger->info($e->getTraceAsString());
            $this->logger->info($mail->ErrorInfo);
        }
    }
}