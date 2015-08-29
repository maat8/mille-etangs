<?php

namespace MilleEtangs\RandonneesBundle\Services;

use JMS\DiExtraBundle\Annotation as DI;
use JMS\DiExtraBundle\Annotation\Service;

use Doctrine\MongoDB\GridFSFile;
use Symfony\Component\HttpFoundation\File\UploadedFile;

use Symm\Gisconverter\Gisconverter;
use MilleEtangs\RandonneesBundle\Document\Trace;
use MilleEtangs\RandonneesBundle\Document\Point;
use MilleEtangs\RandonneesBundle\Document\Itineary;

/**
 * @Service("trace_converter")
 */
class TraceConverter
{
    private $dm;

    private $itineary;
    private $file;
    private $gpx;
    private $kml;
    private $start;

    /**
     * @DI\InjectParams({
     *     "dm" = @DI\Inject("doctrine.odm.mongodb.document_manager")
     * })
     */
    public function __construct($dm)
    {
        $this->dm = $dm;
    }

    public function getGpx()
    {
        return $this->gpx;
    }

    public function getKml()
    {
        return $this->kml;
    }

    public function getStart()
    {
        return $this->start;
    }

    public function generateTracesFromFile(Itineary $itineary, UploadedFile $file)
    {
        $this->itineary = $itineary;

        $this->file = $file;
        $type = $file->getClientOriginalExtension();

        switch($type) {
            case 'gpx':
                $this->gpx = new Trace();
                $this->gpx->setFile($this->file->getPathName());
                $this->dm->persist($this->gpx);
                // Do not flush here : we could be setting gpx/kml itineary fields
                $this->generateKmlFromGpx();
                break;
            case 'kml':
                break;
            default:
                throw \Exception("Format not supported");
        }
    }

    public function generateKmlFromGpx()
    {
        $kml = Gisconverter::gpxToKml(file_get_contents($this->file));
        if (!empty($kml)) {
            // Generate KML file content
            $kml = simplexml_load_string(
                '<?xml version="1.0" encoding="UTF-8"?>' . "\n" .
                '<kml>
                    <Document>
                    <name>'.$this->itineary->getName().'</name>
                    <description>'.$this->itineary->getDescription().'</description>
                    <Style id="difficulty1">
                      <LineStyle>
                        <color>ff1e8d5b</color>
                        <width>4</width>
                      </LineStyle>
                    </Style>
                    <Style id="difficulty2">
                      <LineStyle>
                        <color>ff924f00</color>
                        <width>4</width>
                      </LineStyle>
                    </Style>
                    <Style id="difficulty3">
                      <LineStyle>
                        <color>ff0303c5</color>
                        <width>4</width>
                      </LineStyle>
                    </Style>
                    <Style id="difficulty4">
                      <LineStyle>
                        <color>50000000</color>
                        <width>4</width>
                      </LineStyle>
                    </Style>
                    <Placemark>
                        <name></name>
                        <description></description>
                        <styleUrl>difficulty'.$this->itineary->getDifficulty().'</styleUrl>' .
                $kml .
                '   </Placemark>
                </Document>
                </kml>'
            );

            $this->kml = new Trace();
            $kml_file = new GridFSFile();
            $kml_file->setBytes($kml->asXML());
            $this->kml->setFile($kml_file);

            // Get start point
            $lineString = $kml->xpath("//kml/Document/Placemark/LineString/coordinates");
            list($points) = explode(" ", $lineString[0]->__toString());
            $points = explode(",", $points);
            $this->start = new Point(
                (float) $points[0],
                (float) $points[1]
            );

            // Add xmlns="http://www.opengis.net/kml/2.2"
        }
    }

    public function generateGpxFromKml()
    {
        throw new \Exception("GPX to KML conversion not supported yet");
    }
}
